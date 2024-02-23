<?php
include "sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 0);
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

    <div class="int-main">
        <div class="left">
            <div class="left-top">
                <div class="logo" onclick='openPage(`inicio`, this)'>
                    <div class="img-div">
                        <img src="img/prefeitura.png">
                    </div>
                    <p class="title-p1">Voleibol</p>
                    <p class="title-p2">Escolinhas</p>
                </div>
                <div class="links">
                    <?php if(requireLevel($__TYPE__, 2)){ ?>
                        <button onclick='openPage(`categorias`, this)' id="eventosBt" class='btn'>Categorias</button>
                        <button onclick='openPage(`profissionais`, this)' id="professoresBt" class="btn">Profissionais</button>
                    <?php } ?>
                    <?php if(requireLevel($__TYPE__, 1)){ ?>
                        <button onclick='openPage(`alunos`, this)' id="alunosBt" class='btn'>Alunos</button>
                    <?php } ?>
                    <button onclick='openPage(`turmas`, this)' id="turmasBt" class='btn'>Turmas</button>
                    <button onclick='openPage(`aulas`, this)' id="eventosBt" class='btn'>Aulas</button>
                    <button onclick='openPage(`eventos`, this)' id="eventosBt" class='btn'>Eventos</button>
                    <div class='patrocinadores-div'>
                        <!-- adicionar patrocinadores aqui -->
                    </div>
                </div>
            </div>
            <div class="links">
                <button onclick='openPage(`configuracoes`, this)' id="config" class='btn'>Configurações</button>
            </div>
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
        const btns = document.querySelectorAll(".btn");

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
    </script>
</body>
</html>