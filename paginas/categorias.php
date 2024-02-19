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
<body onload="getActInact('categorias')">
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

    <script src="../js/func.js"></script>
    
</body>
</html>