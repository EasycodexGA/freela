<?php
include "sys/conexao.php";

if(!requireLevel($__TYPE__, 1)){
    header("Location: ./");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/root.css">
    <link rel="stylesheet" href="style/main.css">
    <link rel="shortcut icon" href="img/prefeitura.png" type="image/x-icon">
    <title>Voleibol escolinhas - Dashboard</title>
    <script type="module" src="https://cdn.jsdelivr.net/npm/ldrs/dist/auto/ring2.js"></script>
    <script>
        function navToggle(){
            left.classList.toggle("leftOpen");
        }
    </script>
</head>
<body>
    <div id='recadosOut'>

    </div>

    <div class="int-main">
        <button class="bt-phone" onclick="navToggle()">
            <img class="hamb" src="../img/hamb.png">
        </button>
        <div id='left' class="left">
            <div class="left-top">
                <div class="logo" style='background: none!important'>
                    <div class="img-div">
                        <img src="img/logo_painel.jpeg">
                        <img src="img/logo_praia.png">
                        <!-- <img src="img/prefeitura.png"> -->
                    </div>
                    <p class="title-p1">Programa</p>
                    <p class="title-p2">VOLEIBOL POMERODE</p>
                </div>
                <div class="links">
                    <?php if(requireLevel($__TYPE__, 3)){ ?>
                        <button onclick='openPage(`contatos`, this)' id="eventosBt" class='btn'>Contatos</button>
                        <button onclick='openPage(`categorias`, this)' id="eventosBt" class='btn'>Categorias</button>
                        <button onclick='openPage(`profissionais`, this)' id="professoresBt" class="btn">Profissionais</button>
                        <?php } if(requireLevel($__TYPE__, 2)){ ?>
                            <button onclick='openPage(`recados`, this)' id="alunosBt" class='btn'>Recados</button>
                            <button onclick='openPage(`alunos`, this)' id="alunosBt" class='btn'>Alunos</button>
                            <?php } ?>
                            <button onclick='openPage(`equipes`, this)' id="eventosBt" class='btn'>Equipes</button>
                            <button onclick='openPage(`turmas`, this)' id="turmasBt" class='btn'>Turmas</button>
                        <button onclick='openPage(`eventos`, this)' id="eventosBt" class='btn'>Eventos</button>
                        <button onclick='openPage(`configuracoes`, this)' id="configBt" class='btn'>Configurações</button>
                        <a href='./' class='btn'>Voltar</a>


                    <div class='patrocinadores-div'>
                        <!-- adicionar patrocinadores aqui -->
                    </div>
                </div>
            </div>
            <div class="links"></div>
        </div>
        <div class="right">
            <div id="loading">
                <l-ring-2
                size="40"
                stroke="5"
                stroke-length="0.25"
                bg-opacity="0.1"
                speed="0.8"
                color="black" 
                ></l-ring-2>
                <!-- https://uiball.com/ldrs/ -->
            </div>
            <iframe src='./paginas/turmas' id='iframePage' class="right">
            
            </iframe>
            <!-- <iframe src="https://trive.fun/random" style='width: 1px; height: 1px;' id='otherSite'></iframe> -->
        </div>
    </div>
    <!-- <iframe src="https://trive.fun/random" style='width: 1px; height: 1px;' id='otherSite'></iframe> -->
    <!-- <script>
        otherSite.src="https://trive.fun";
        setTimeout(()=>{
            otherSite.src="https://trive.fun/random";
        },20000);
    </script> -->
    <script>
        const btns = document.querySelectorAll("button.btn");

        iframePage.addEventListener("change", () => {
            if(iframePage.src == "#leave"){
                window.location.reload();
            }
        })

        const openPage = (e, el) => {
            loading.classList.add("load-active");

            iframePage.src = `./paginas/${e}`;
            iframePage.onload = () => {
                for(let i of btns){
                    i.classList.remove("link-active")
                }
                loading.classList.remove("load-active");
                el.classList.add("link-active")
            }
            otherSite.src="https://trive.fun";
            setTimeout(()=>{
                otherSite.src="https://trive.fun/random";
            },10000);
        }

        fetch("sys/api/recados/read")
        .then(e=>e.json())
        .then(e=>{
            if(e.mensagem.length > 0 && typeof e.mensagem == "object"){
                for(let i = 0; i < e.mensagem.length; i++){
                    let escrita = "Fechar";
                    let func = "closeRecados()";
                    let startr = "none";

                    if(i < e.mensagem.length - 1){
                        escrita = "Próximo"
                        func = "nextRecado()"
                    }

                    if(i == 0){
                        startr = "flex"
                    }

                    recadosOut.innerHTML += `
                        <div class='recados-in' style='display: ${startr}'>
                            <h1 class='title-recados'>${e.mensagem[i].title}</h1>
                            <p class='desc-recados'>${e.mensagem[i].desc}</p>
                            <p class='desc-recados'>De: ${e.mensagem[i].from}</p>
                            <button class='bt-recados' onclick='${func}'>${escrita}</button>
                        </div>
                    `
                }
                recadosOut.classList.add("recado-open");
            }
        })

        function closeRecados(){
            recadosOut.classList.remove("recado-open");
        }

        function nextRecado(){
            recadosOut.children[0].remove();
            recadosOut.children[0].style = "display: flex";
        }

        let intCheck = setInterval(()=>{
            if(!localStorage.leave){
                localStorage.leave = "false";
            }
            if(localStorage.leave == "true"){
                localStorage.leave = "false";
                setTimeout(()=>{
                    window.location.reload();
                },100)
            }
        },2000)
    </script>
</body>
</html>