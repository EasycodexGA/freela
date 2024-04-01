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
            padding: 8px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px #00000015;
            gap: 20px;
        }
        .right-h{
            display: flex;
            gap: 12px;
            align-items: center;
        }
        .link-h {
            color: black;
        }
        .login-h {
            color: white;
            background: var(--contraste3);
            padding: 5px 10px;
            border-radius: 3px;
            font-size: 14px;
        }
        section#banner {
            position: relative;
            height: 60svh;
            background: gray;
            overflow: hidden;
        }
        section img{
            width:100%;
            height: 100%;
            position: absolute;
            object-fit: cover;
        }

        #black{
            position: absolute;
            width: 100%;
            height: 100%;
            background: #000000bf;
        }
        .container{
            width: calc(100% - 50px);
            padding: 15px 25px;
            margin: auto;
            max-width: 930px;
        }
    </style>
</head>
<body>
    <nav class='highheader'>
        <h1>O esporte em você</h1>
        <span>GRATUITO</span>
        <h1>Entre em contato ➔</h1>
    </nav>
    <header>
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
    <section id='banner'>
        <img src='./img/time.png'>
        <div id='black'></div>
    </section>
    <section id='sobre' class='container'>
        <h1>Sobre o projeto</h1>
    </section>
    <section id='patrocinadores' class='container'>
        <h1>Patrocinadores</h1>
    </section>
    <section id='contato' class='container'>
        <h1>Contato</h1>
    </section>
    <section id='responsavel' class='container'>
        <h1>Responsável</h1>
    </section>
    <section id='localizacao' class='container'>
        <h1>Localização</h1>
    </section>
</body>
</html>