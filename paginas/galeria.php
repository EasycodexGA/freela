<?php
include "../sys/conexao.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="../style/paginas.css">
    <link rel="shortcut icon" href="../img/prefeitura.png" type="image/x-icon">
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring2.js"></script>
    <script src="../js/func.js"></script>
</head>
<body>
    <div id="seeImg" bis_skin_checked="1">
        <img id='seeInImg' src="">
        <div class="seeBtns">
            <button onclick='seeImg.style.display=`none`' class="seeFechar">Fechar</button>
            <?php if(requireLevel($__TYPE__, 2)){ ?>
            <button onclick='excluirSee()' id="seeExcluir">Excluir</button>
            <?php } ?>
        </div>
    </div>
    <header>
        <h1 class='title-header'>Galeria</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="galeriasT">0</span> Galerias</h2>
            <h2 class='sub-header'><span id="imagensT">0</span> Imagens</h2>
        </div>
    </header>

    <?php if(requireLevel($__TYPE__, 2)){ ?>
    <div id='details'></div>
    <div id='verMaisDiv'></div>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addGaleria)' class='funcBt'>+ Criar pasta</button>
            <button onclick='openAdd(addImages)' class='funcBt'>+ Enviar imagens</button>
        </div>
    </div>

    <div id='addNew'>
        <div id='addGaleria' class='add-container'>
            <h1 class='title-add'>Nova pasta</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Campeonato Estadual'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("galeria/grupo/add", {
                    nome: nomeAdd.value
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
        <div id='addImages' class='add-container'>
            <h1 class='title-add'>Enviar imagens</h1>

            <div class='inps-add'>
                <div class='inp-add-out-img'>
                    <h3>Pasta</h3>
                    <select id='pastaAdd'>
                        <option value=''>Nenhuma pasta selecionada</option>
                    </select>
                </div>
                <div class='inp-add-out-img'>
                    <h3>Imagens</h3>
                    <label for='imageAdd'>Escolher imagens</lavel>
                    <input id='imageAdd' multiple type='file' hidden placeholder='Nova imagem' accept="image/png, image/jpeg, image/webp"/>
                </div>
            </div>
            <div id='outShowImgs' class='inps-add'></div>
            <div id='countOut' class='inps-add'></div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='sendImgs()' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <!-- script só para adm/professor  -->
    <script>
        imageAdd.addEventListener("change", e=>{
            generatePreview();
        })

        const generatePreview = async () => {
            let getAll = imageAdd.files;

            console.log(getAll)

            let tamanhoT = 0;

            for(let i = 0; i < getAll.length; i++){
                tamanhoT += getAll[i].size / 1000000;
                if((getAll[i].size / 1000000) > 5){
                    newMsg({
                        mensagem: "Tamanho máximo de imagem: 5MB.",
                        response: false,
                    })
                    return;
                }
            }

            if(getAll.length > 300){
                newMsg({
                    mensagem: "Mais de 300 arquivos",
                    response: false
                })

                return;
            } else if(tamanhoT > 1000){
                newMsg({
                    mensagem: "Total mais pesado que 1GB",
                    response: false
                })

                return;
            }
            let time = 0;
            countOut.innerHTML = "";
            outShowImgs.innerHTML = "";
            for(let i = 0; i < getAll.length; i++){
                outShowImgs.innerHTML += `
                    <div id='showgp${i}' class='imgShowUp'>
                        <div class='infos-out'>
                            <div class='preimg'>
                                <img id='preimgshow${i}' src=''/>
                            </div>
                            <p class='nameImgShow'>${getAll[i].name}</p>
                        </div>
                        <p class='nameImgShow'>Pronto</p>
                    </div>
                `;
                countOut.innerHTML = `${i + 1} de ${getAll.length} - ${tamanhoT.toFixed(2)}MB`;
            }
            outShowImgs.scrollTo(0, 9999999);
            showpreimg();
        }

        async function showpreimg(){
            let getAll = imageAdd.files;
            for(let i = 0; i < getAll.length; i++){
                let img64 = await getBase64(getAll[i]);

                document.getElementById(`preimgshow${i}`).src = img64;

            }
        }
        const excluirSee = () => {
            let xx = confirm("Deseja continuar?");
            if(!xx) return;

            let id = seeExcluir.dataset.idfoto;
            if(!id) return;

            fetch(`../sys/api/galeria/foto/remove`,{
                method: "POST",
                body: JSON.stringify({
                    id: Number(id)
                })
            })
            .then(e=>e.json())
            .then(e=>{
                newMsg(e);
            })
            .catch(e=>newMsg({
                mensagem: "Ocorreu algum erro, contate o administrador",
                response: false
            }))
        }

        const excluirGp = async (el, e, imgs) => {
            let xx = confirm("Deseja continuar?");
            if(!xx) return;

            let timerLoc = document.getElementById(`estimativa${e}`);

            el.innerHTML = `
                <l-ring-2 size="15" stroke="3" stroke-length="0.25" bg-opacity="0.1" speed="0.8" color="white"></l-ring-2>
            `;

            let imgse = imgs;

            if(imgs >= 500){
                imgse = 500;
                newMsg({
                    mensagem: `Limite de exclusão: ${imgse} por vez`,
                    response: "aguardando"
                })
                await sleep(2000);
            }

            
            let times = Math.floor(imgse * 0.035);

            timerLoc.innerText = `Aguardando estimativa`;

            let intervalTimer = setInterval(() => {
                timerLoc.innerText = `Estimativa: ${times} segundos`;
                if(times <= 0){
                    timerLoc.innerText = `Finalizando...`;
                    clearInterval(intervalTimer);
                }
                times--;

            }, 1000);

            newMsg({
                mensagem: "Isso pode demorar um pouco, não atualize a página",
                response: "aguardando"
            })

            fetch(`../sys/api/galeria/grupo/remove`,{
                method: "POST",
                body: JSON.stringify({
                    id: Number(e)
                })
            })
            .then(e=>e.json())
            .then(e=>{
                el.innerHTML = "Excluir";
                clearInterval(intervalTimer);
                timerLoc.innerText = "";
                newMsg(e);
            })
            .catch(e=>newMsg({
                mensagem: "Ocorreu algum erro, contate o administrador",
                response: false
            }))
        }
    </script>
    <?php } ?>

    <div id="gpOut">

    </div>

    <script>
        fetch("../sys/api/galeria/grupo/get")
        .then(e=>e.json())
        .then(e=>{
            let galeriasTT = e.mensagem.length;
            let imagensTT = 0;
            
            console.log(e)
            <?php if(requireLevel($__TYPE__, 2)){ ?>
                for(let i of e.mensagem){
                    pastaAdd.innerHTML += `
                        <option value='${i.id}'>${i.nome}</option>
                    `;
                }
            <?php } ?>

            for(let i of e.mensagem){
                let nomeGp = i.nome;
                let imgs = "";

                if(i.imagens.length == 0){
                    imgs = "<p>Nenhuma imagem nessa galeria</p>"
                }

                for(let o of i.imagens){
                    imagensTT++;
                    imgs += `
                        <img onclick="openImgGal('${o.imagem}', ${o.id})" id='img${i.id}${o.id}' src='${o.imagem}'>
                    `;
                }
                


                gpOut.innerHTML += `
                    <div class='contGp'>
                        <div style='display: flex; gap: 10px; align-items: center'>
                            <h1 id='gp${i.id}' class='titleGp'>${nomeGp}</h1>-<h4 class='titleGpImg'>${i.imagens.length} Imagens</h4>
                            <?php if(requireLevel($__TYPE__, 2)){ ?>
                                <button onclick='excluirGp(this, ${i.id}, ${i.imagens.length})' data-gpown='gp${i.id}' id="excGp">Excluir</button>
                                <span id='estimativa${i.id}'></span>
                            <?php } ?>
                        </div>
                        <div class='contImgGp'>
                            ${imgs}
                        </div>
                    </div>
                `;

                imagensT.innerText = imagensTT;
                galeriasT.innerText = galeriasTT;
                
            }

        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))

        const openImgGal = (src, id) => {
            seeInImg.src = src;
            seeImg.style.display = "flex";
            seeExcluir.dataset.idfoto = id;
        }
    </script>
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">moontis.com</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu Vôlei - Galeria&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
    <script src="https://whos.amung.us/pingjs/?k=totalmoontis&t=Partiu Vôlei - Galeria&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>

</body>
</html>

