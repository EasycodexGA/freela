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
    <link rel="stylesheet" href="style/landing.css">
    <link rel="shortcut icon" href="img/prefeitura.png" type="image/x-icon">
    <title>Partiu vôlei - Vôleibol escolinhas</title>
    <style>
        *{
            font-family: Righteous, sans-serif!important;
        }
        .highheader{
            background: var(--contraste3);
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 5px 15px;
        }
        .highheader h1, .highheader span{
            color: white;
            font-size: 16px;
        }

        .highheader span{
            font-size: 14px
        }

        header{
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
    </style>
</head>
<body>
    <div class='highheader'>
        <h1>O esporte em você</h1>
        <span>GRATUITO</span>
        <h1>Entre em contato -></h1>
    </div>
    <hedaer>
        <div class='left-h'>
            <img src='./img/logo.png'>
        </div>
        <div class='right-h'>
            <a href='#' class='link-h'>Início</a>
            <a href='#' class='link-h'>Sobre</a>
            <a href='#' class='link-h'>Patrocinadores</a>
            <a href='#' class='link-h'>Contato</a>
            <a href='#' class='link-h'>Local</a>
            <a href='#' class='link-h login-h'>Entrar</a>
        </div>
    </header>
</body>
</html>