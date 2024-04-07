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
<body >
    <header>
        <h1 class='title-header'>Geral - Categorias</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>
    <div id='addNewAula'></div>

    <div id='details'>
        <div class='add-container' id='detailContainer'></div>
    </div>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addCategoria)' class='funcBt'>+ Adicionar Categoria</button>
        </div>
    </div>

    

    <div id='addNew'>
        <div id='addCategoria' class='add-container'>
            <h1 class='title-add'>Nova categoria</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Sub n'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("usuarios/cadastrar/categoria", {
                    nome: nomeAdd.value
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <div id='verMaisDiv'></div>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Categorias</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead id='headList'></thead>
            <tbody id='tabList'></tbody>
        </table>
    </div>


    <script src="../js/class.js"></script>
    <script>const file = new Categorias(<?php echo $__TYPE__; ?>);</script>
    <script src="../js/func.js" defer></script>
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">moontis.com</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu Vôlei - Categorias - T: <?php echo $__TYPE__; ?>&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>

</body>
</html>