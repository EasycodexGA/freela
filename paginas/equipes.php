<?php
include "../sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 3);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="../style/paginas.css">
    <link rel="shortcut icon" href="../img/prefeitura.png" type="image/x-icon">
    
</head>
<body>
    <header>
        <h1 class='title-header'>Geral - Equipes</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick="newMsg({mensagem: 'Em desenvolvimento', response: 'aguardando'})" class='funcBt'>+ Adicionar equipe</button>
        </div>
    </div>


    <!-- <script src="../js/class.js"></script>
    <script>const file = new Turmas(<?php echo $__TYPE__; ?>);</script>-->
    <script src="../js/func.js"></script> 
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">codity.com.br</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
</body>
</html>