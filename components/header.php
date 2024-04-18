<?php
include "../sys/conexao.php";

$escrita = "Entrar";

if(requireLevel($__TYPE__, 1)){
    $escrita = "Painel";
}

$siteGet = mysqli_query($__CONEXAO__, "select logo from configs where id='1'") or die("Atualize a página e tente novamente");
$assocBanner = mysqli_fetch_assoc($siteGet);

$imgLogo = decrypt($assocBanner["logo"]);
$locLogoImg = "$__WEB__/imagens/website/$imgLogo";

// <img src='./img/logo.png'>
$_HEADER_ = "
    <subheader class='highheader'>
        <h1>O esporte em você</h1>
        <span>GRATUITO</span>
        <h1>Entre em contato ➔</h1>
    </subheader>
    <header>
        <div class='left-h'>
            <img src='$locLogoImg' onerror='this.style.diplay=`none`'>
        </div>
        <div class='right-h'>
            <a href='./' class='link-h'>Início</a>
            <a href='#sobre' class='link-h'>Sobre</a>
            <a href='#patrocinadores' class='link-h'>Patrocinadores</a>
            <a href='#contato' class='link-h'>Contato</a>
            <a href='#localizacao' class='link-h'>Local</a>
            <a href='./galeria' class='link-h'>Galeria</a>
            <a href='./login' class='link-h login-h'>$escrita</a>
            <button class='menu-h' onclick='navToggle(`open`)'>
                <img class='hamb' src='../img/hamb.png'>
            </button>
        </div>
    </header>
    <nav id='navItem' class='nav'>
        <div class='nav-h'>
            <button class='close-nav' onclick='navToggle(`close`)'>x</button>
            <a href='./' class='link-h'>Início</a>
            <a href='#sobre' class='link-h'>Sobre</a>
            <a href='#patrocinadores' class='link-h'>Patrocinadores</a>
            <a href='#contato' class='link-h'>Contato</a>
            <a href='#localizacao' class='link-h'>Local</a>
            <a href='./galeria' class='link-h'>Galeria</a>
        </div>
    </nav>

    <script>
        function navToggle(e){
            if(e == 'open'){
                navItem.classList.add('navOpen')
                return;
            }
            navItem.classList.remove('navOpen')
        }
    </script>
";