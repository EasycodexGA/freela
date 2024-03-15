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
    <script src="../js/func.js"></script>
</head>
<body>
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
                <div class='inp-add-out'>
                    <h3>Pasta</h3>
                    <select id='pastaAdd'>
                        <option value=''>Nenhuma pasta selecionada</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Imagens</h3>
                    <input id='imageAdd' multiple type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
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

            let tamanhoT = 0;

            for(let i = 0; i < getAll.length; i++){
                tamanhoT += getAll[i].size / 1000000;
            }

            if(files.length > 300){
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
                countOut.innerHTML = `${i + 1} de ${getAll.length}`;
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
                        <img id='img${i.id}${o.id}' src='${o.imagem}'>
                    `;
                }

                gpOut.innerHTML += `
                    <div class='contGp'>
                        <h1 class='titleGp'>${nomeGp}</h1>
                        <div class='contImgGp'>
                            ${imgs}
                        </div>
                    </div>
                `;

                imagensT.innerText = imagensTT;
                galeriasT.innerText = galeriasTT;
                
            }

        })
    </script>
</body>
</html>