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
                <div class="logo">
                    <div class="img-div">
                        <img src="img/prefeitura.png">
                    </div>
                    <p class="title-p1">Voleibol</p>
                    <p class="title-p2">Escolinhas</p>
                </div>
                <div class="links">
                    <button onclick='openPage(`professores`)' id="professoresBt" class="link-active">Professores</button>
                    <button onclick='openPage(`alunos`)' id="alunosBt">Alunos</button>
                    <button onclick='openPage(`turmas`)' id="turmasBt">Turmas</button>
                    <button onclick='openPage(`eventos`)' id="eventosBt">Eventos</button>
                </div>
            </div>
            <div class="left-bottom">
                <button onclick='openPage(`configuracoes`)' id="config">Configurações</button>
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
        const openPage = (e) => {
            loading.classList.add("load-active");

            iframePage.src = `./paginas/${e}`;
            iframePage.onload = () => {
                loadingPage.classList.remove("load-active");
            }
        }
    </script>
</body>
</html>