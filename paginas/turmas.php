<?php
include "../sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 0);
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
<body>
    <header>
        <h1 class='title-header'>Geral - Turmas</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <?php if(requireLevel($__TYPE__, 2)){ ?>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addTurma)' class='funcBt'>+ Adicionar turma</button>
            <!-- <button onclick='openAdd(addAula)' class='funcBt'>+ Adicionar aula</button> -->
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
                        <option value=''>Nenhuma turma</option>
                    </select>
                </div>
            </div>
            <button onclick='addNewData("turmas/cadastrar/turma", {
                nome: nomeAdd.value,
                categoria: categoriaAdd.value,
            })' class='btn-add'>Salvar</button>
        </div>
    </div>
    
    <?php } ?>
    
    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Turmas</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Profissionais</th>
                    <th>Alunos</th>
                    <th></th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id='tabList'></tbody>
        </table>

    </div>
    <script>
        fetch("../sys/api/usuarios/get/categorias")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            
            for(let i of e.mensagem){
                categoriaAdd.innerHTML += `
                    <option value='${i.nome}'>${i.nome}</option>
                `;
            }
        })
    </script>
    <script src="../js/func.js"></script>
    <script>
        getActInact('turmas')
        getTurmas()
    </script>
    
</body>
</html>