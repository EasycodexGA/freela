<?php
include "../sys/conexao.php";

$escrita = "Entrar";

if(requireLevel($__TYPE__, 1)){
    $escrita = "Painel";
}

$_HEADER_ = "
    <subheader class='highheader'>
        <h1>O esporte em você</h1>
        <span>GRATUITO</span>
        <h1>Entre em contato ➔</h1>
    </subheader>
    <header>
        <div class='left-h'>
            <img src='./img/logo.png'>
        </div>
        <div class='right-h'>
            <a href='./' class='link-h'>Início</a>
            <a href='#sobre' class='link-h'>Sobre</a>
            <a href='#patrocinadores' class='link-h'>Patrocinadores</a>
            <a href='#contato' class='link-h'>Contato</a>
            <a href='#localizacao' class='link-h'>Local</a>
            <a href='./galeria' class='link-h'>Galeria</a>
            <a href='./login' class='link-h login-h'>$escrita</a>
            <button class='menu-h' onclick='alert(`hamb`)'>
                <img class='hamb' src='../img/hamb.png'>
            </button>
        </div>
    </header>
    <nav class='nav'>
        <div class='nav-h'>
            <a href='./' class='link-h'>Início</a>
            <a href='#sobre' class='link-h'>Sobre</a>
            <a href='#patrocinadores' class='link-h'>Patrocinadores</a>
            <a href='#contato' class='link-h'>Contato</a>
            <a href='#localizacao' class='link-h'>Local</a>
            <a href='./galeria' class='link-h'>Galeria</a>
        </div>
    </nav>
";