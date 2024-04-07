<?php
include "sys/conexao.php";

$escrita = "Entrar";

if(requireLevel($__TYPE__, 1)){
    $escrita = "Painel";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/root.css">
    <link rel="stylesheet" href="style/landing.css">
    
<!-- Descrição do Site -->
<meta name="description" content="Descubra o Projeto Pomerode Voleibol 2024 – promovendo inclusão social e excelência no voleibol para crianças e jovens em Pomerode, totalmente gratuito.">

<!-- Palavras-chave -->
<meta name="keywords" content="Projeto Pomerode Voleibol, inclusão social, voleibol gratuito, desenvolvimento esportivo, Pomerode, voleibol para jovens">

<!-- Autor do Site -->
<meta name="author" content="Partiu Vôlei">

<!-- Indicação de Idioma -->
<meta http-equiv="content-language" content="pt-BR">

<!-- Direitos Autorais -->
<meta name="copyright" content="Partiu Vôlei">
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
        #banner img{
            width:100%;
            height: 100%;
            position: absolute;
            object-fit: cover;
        }

        #black {
            position: absolute;
            width: calc(100% - 100px);
            height: calc(100% - 40px);
            padding: 20px 20px 20px 80px;
            background: #000000bf;
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 20px;
        }
        .top-black h1 {
            color: white;
            font-size: 30px;
        }
        .top-black h2 {
            color: lightgrey;
            font-size: 18px;
        }

        .top-black p {
            color: white;
            font-size: 17px;
        }

        .top-black p span{
            color: #FFB951;
            font-size: 17px;
        }

        #black a {
            color: white;
            font-size: 16px;
            padding: 8px 15px;
            border-radius: 3px;
            background: var(--contraste3);
            width: fit-content;
        }

        .top-black{
            display: flex;
            flex-direction: column;
            gap: 5px;
        }


        .container{
            width: calc(100% - 50px);
            padding: 15px 25px;
            margin: 30px auto;
            max-width: 930px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .container h1{
            font-size: 22px;
            color: #656565;
        }

        .container p{
            color: #858585;
            text-align: justify;
        }
        #patrocinador {
            display: flex;
            flex-wrap: wrap;
            gap: 40px;
            align-items: center;
        }
        #patrocinador img {
            width: 100%;
            max-width: 150px;
        }
        section#contato, section#localizacao {
            border-radius: 5px;
            background: var(--contraste3);
            padding: 25px 20px;
        }
        #contato h1, #localizacao h1{
            color: white;
        }
        .infos p {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        form{
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .inpout {
            width: calc(100% / 3 - 10px);
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .inpout label {
            color: white;
        }
        .inpout input {
            padding: 8px 10px;
            border-radius: 2px;
            font-size: 13px;
        }

        form button {
            background: var(--contraste);
            color: white;
            padding: 8px;
            width: 100%;
        }
        #localizacao .infos p{
            color: white;
        }

        footer{
            margin-top: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            background: var(--contraste3);
        }
        .container#localizacao {
            flex-direction: row;
            gap: 30px;
            justify-content: space-between
        }
        #localizacao iframe{
            border-radius: 10px;
            cursor: pointer;
            width: 50%;
        }
        .in-loc{
            display: flex;
            flex-direction: column;
            gap: 15px
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
            <a href='./' class='link-h'>Início</a>
            <a href='#sobre' class='link-h'>Sobre</a>
            <a href='#patrocinadores' class='link-h'>Patrocinadores</a>
            <a href='#contato' class='link-h'>Contato</a>
            <a href='#localizacao' class='link-h'>Local</a>
            <a href='./login' class='link-h login-h'><?php echo $escrita; ?></a>
        </div>
    </header>
    <section id='banner'>
        <img src='./img/time.png'>
        <div id='black'>
            <div class='top-black'>
                <h1>Projeto desportivo</h1>
                <h2>Por: Prefeitura de Pomerode</h2>
            </div>
            <div class='top-black'>
                <p>-> Do <span>Sub 13</span> ao <span>Sub 19</span>
                <p>-> Vôlei de quadra</p>
                <p>-> Vôlei de praia</p>
            </div>
            <a href='#contato'>Entrar em contato</a>
        </div>
    </section>
    <section id='sobre' class='container'>
        <h1>Sobre o projeto</h1>
        <p>Projeto desportivo que mira, além da inclusão social, o rendimento desportivo individual e coletivo. Em sua essência, o PROJETO POMERODE VOLEIBOL 2024, visa oportunizar às crianças e jovens do município de Pomerode o contato com a modalidade VOLEIBOL de forma gratuita e em um ambiente saudável e integrado com a sociedade.</p>
    </section>
    <section id='patrocinadores' class='container'>
        <h1>Patrocinadores</h1>
        <div id='patrocinador'>
            <img src="https://partiuvolei.com/imagens/patrocinadores/i17104004235d47ee.png">
            <img src="https://partiuvolei.com/imagens/patrocinadores/i17104004235d47ee.png">
        </div>
    </section>
    <section id='contato' class='container'>
        <h1>Contato</h1>
        <form action='javascript:void(0)' class='contato'>
            <div class='inpout'>
                <label for="nome">Nome</label>
                <input id='nome' type='text' placeholder='Fulano ciclano'>
            </div>
            <div class='inpout'>
                <label for="email">Email</label>
                <input id='email' type='text' placeholder='exemplo@gmail.com'>
            </div>
            <div class='inpout'>
                <label for="telefone">Telefone</label>
                <input id='telefone' type='text' placeholder='47 9 9999-9999'>
            </div>
            <button onclick="dhuiashduih()">Enviar</button>
        </form>
    </section>
    <section id='responsavel' class='container'>
        <h1>Responsável</h1>
        <div style="display:flex; gap: 30px; align-items: center;">
        <div style="width: 125px; aspect-ratio: 1; position: relative; border-radius: 100px; overflow: hidden;">
            <img style="position: absolute; width: 100%; height: 100%; object-fit: cover;" src="../img/luciano.jpg">
        </div>
        <div class="infos">
            <h1 class="title-header">Contato</h1>
            <p>
                <span>Prof. Luciano Menegaz</span>
                <span>F. (48) 99806 0667</span>
                <span>lucianor.menegaz@gmail.com</span>
            </p>
        </div>
    </div>
    </section>
    <section id='localizacao' class='container'>
        <div class='in-loc'>
            <h1>Localização</h1>
            <div class="infos">
                <p>
                    <span>Ginasio Ralf Knaesel</span>
                    <span>Secretaria de Eventos, Esporte e Lazer</span>
                    <span>Endereço: Av. 21 de Janeiro - 2700</span>
                    <span>Pomerode - SC</span>
                    <span>Telefone(s): (47) 3387-2612</span>
                    <span>E-mail: seel@pomerode.sc.gov.br</span>
                </p>
            </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3562.9092508258436!2d-49.17863312611888!3d-26.747271886308685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dee4e2425a8187%3A0x1eac4ba30a292981!2sAv.%2021%20de%20Janeiro%2C%202700%20-%20Centro%2C%20Pomerode%20-%20SC%2C%2089107-000!5e0!3m2!1spt-BR!2sbr!4v1712531316409!5m2!1spt-BR!2sbr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>

    <footer>
        <img src='./img/logo2.png'>
    </footer>

    <script src='js/func.js'></script>
    <script>
        function dhuiashduih(){
            fetch("./sys/api/contato/send",{
                method: "POST",
                body: JSON.stringify({
                    nome: nome.value,
                    email: email.value,
                    telefone: telefone.value
                })
            })
            .then(e=>e.json())
            .then(e=>{
                newMsg(e);
                if(e.response){
                    nome.value = "";
                    email.value = "";
                    telefone.value = "";
                }
            })
        }
    </script>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu%20v%C3%B4lei%20-%20V%C3%B4leibol%20escolinhas&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
    <script src="https://whos.amung.us/pingjs/?k=totalmoontis&t=Partiu%20v%C3%B4lei%20-%20V%C3%B4leibol%20escolinhas&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
</body>
</html>