<?php
include "sys/conexao.php";
justLog($__EMAIL__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vôlei</title>
    <style>
        .int-main {
            display: flex;
            height: 100svh;
        }

        .left{
            width: 30%;
            max-width: 250px;
            background: var(--contraste2);
            display: flex;
            justify-content: center;
            min-height: calc(100svh - 40px);
            padding: 20px 0;
        }

        .right{
            width: 100%;
            overflow-y: scroll;
            overflow-x: hidden;
            padding-bottom: 100px;
        }

        .logo {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }

        .img-div {
            width: 50px;
        }

        .img-div img {
            width: 100%;
        }

        .title-p1 {
            text-transform: uppercase;
            font-weight: 600;
            font-size: 1.3rem;
        }

        .title-p2 {
            color: var(--contraste);
            text-transform: uppercase;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="int-main">
        <div class="left">
            <div class="logo">
                <div class="img-div">
                    <img src="img/prefeitura.jpg">
                </div>
                <p class="title-p1">Voleibol</p>
                <p class="title-p2">Escolinhas</p>
            </div>
            <div class="links">
                <button>Professores</button>
            </div>
        </div>
        <div class="right">

        </div>
    </div>
</body>
</html>