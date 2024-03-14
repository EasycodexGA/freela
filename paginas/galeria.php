<?php
include "../sys/conexao.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/root.css">
    <link rel="stylesheet" href="../style/paginas.css">
    <link rel="shortcut icon" href="../img/prefeitura.png" type="image/x-icon">
    <script src="../js/func.js"></script>
</head>
<body>
    <h1 class='title-header'>Galeria</h1>

    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <div id='details'></div>
    <div id='verMaisDiv'></div>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addGaleria)' class='funcBt'>+ Criar pasta</button>
            <button onclick='' class='funcBt'>+ Enviar imagens</button>
        </div>
    </div>

    <div id='addNew'>
        <div id='addGaleria' class='add-container'>
            <h1 class='title-add'>Nova pasta</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Campeonato Estadual'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("galeria/grupo/add", {
                    nome: nomeAdd.value
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
        <div id='addImages' class='add-container'>
            <h1 class='title-add'>Enviar imagens</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Pasta</h3>
                    <select id='pasta'>
                        <option>Nenhuma pasta selecionada</option>
                    </select>
                </div>
            </div>
            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Imagens</h3>
                    <input id='imageAdd' multiple type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("galeria/grupo/add", {
                    nome: nomeAdd.value
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <?php } ?>
</body>
</html>