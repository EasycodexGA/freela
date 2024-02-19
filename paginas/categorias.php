<?php
include "../sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="../style/main.css">
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
            <button onclick='addNewData("usuarios/cadastrar/categoria", {
                nome: nomeAdd.value
            })' class='btn-add'>Salvar</button>
        </div>
    </div>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Categorias</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Turmas</th>
                    <th></th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id='tabList'></tbody>
        </table>
    </div>
    
    <script src="../js/func.js"></script>
    <script>
        getActInact('categorias')
        getCategorias()
    </script>
</body>
</html>