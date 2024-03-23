<?php
include "sys/conexao.php";

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
</head>
<body>
    <div id='recadosOut'>

    </div>

    <div class="int-main">
        <div class="left">
            <div class="left-top">
                <div class="logo" style='background: none!important' onclick='openPage(`inicio`, this)'>
                    <div class="img-div">
                        <img src="img/prefeitura.png">
                    </div>
                    <p class="title-p1">Voleibol</p>
                    <p class="title-p2">Escolinhas</p>
                </div>
                <div class="links">
                    <button onclick='openPage(`galeria`, this)' id="eventosBt" class='btn'>Galeria</button>
                    <?php if(requireLevel($__TYPE__, 3)){ ?>
                        <button onclick='openPage(`categorias`, this)' id="eventosBt" class='btn'>Categorias</button>
                        <button onclick='openPage(`profissionais`, this)' id="professoresBt" class="btn">Profissionais</button>
                    <?php } if(requireLevel($__TYPE__, 2)){ ?>
                        <button onclick='openPage(`recados`, this)' id="alunosBt" class='btn'>Recados</button>
                        <button onclick='openPage(`alunos`, this)' id="alunosBt" class='btn'>Alunos</button>
                    <?php } if(requireLevel($__TYPE__, 1)){ ?>
                        <button onclick='openPage(`turmas`, this)' id="turmasBt" class='btn'>Turmas</button>
                        <button onclick='openPage(`eventos`, this)' id="eventosBt" class='btn'>Eventos</button>
                        <button onclick='openPage(`configuracoes`, this)' id="configBt" class='btn'>Configurações</button>
                    <?php } else { ?>
                        <button onclick="location.href='login'" class='btn'>Login</button>
                    <?php } ?>

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
            <iframe src='./paginas/inicio' id='iframePage' class="right">
            
            </iframe>
        </div>
    </div>

    <script>
        const btns = document.querySelectorAll("button.btn");

        iframePage.onchange = () => {
            if(iframePage.src == "#leave"){
                window.location.reload();
            }
        }

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
    </script>
</body>
</html>