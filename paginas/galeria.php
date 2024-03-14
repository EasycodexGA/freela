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
</head>
<body>
    <h1 class='title-header'>Galeria</h1>

    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addTurma)' class='funcBt'>+ Adicionar turma</button>
            <button onclick='' class='funcBt'>+ Novo recado</button>
        </div>
    </div>

    <div id='addNew'>
        <div id='addTurma' class='add-container'>
            <h1 class='title-add'>Nova turma</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Vôlei de praia'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Categorias</h3>
                    <select id='categoriaAdd'>
                        <option value=''>Nenhuma categoria</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Responsável</h3>
                    <select id='profissionalAdd'>
                        <option value=''>Nenhum profissional</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Horário</h3>
                    <input id='horarioAdd' type='time'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("turmas/cadastrar/turma", {
                    nome: nomeAdd.value,
                    categoria: categoriaAdd.value,
                    horario: horarioAdd.valueAsNumber,
                    profissional: profissionalAdd.value,
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <?php } ?>
</body>
</html>