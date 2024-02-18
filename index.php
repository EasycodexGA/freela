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
                    <button id="professoresBt" class="link-active">Professores</button>
                    <button id="alunosBt">Alunos</button>
                    <button id="turmasBt">Turmas</button>
                    <button id="eventosBt">Eventos</button>
                </div>
            </div>
            <div class="left-bottom">
                <button id="config">Configurações</button>
            </div>
        </div>
        <div class="right">

        </div>
    </div>
</body>
</html>