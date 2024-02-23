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
    <script src="../js/func.js"></script>
</head>
<body>
    <header>
        <h1 class='title-header'>Geral - Aulas</h1>
    </header>

    <div id='details'>
        <div class='add-container'>
            <h1 class='title-add'>Detalhes</h1>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='javascript:void(0)' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <?php if(requireLevel($__TYPE__, 1)){ ?>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addAula)' class='funcBt'>+ Adicionar aula</button>
        </div>
    </div>

    <div id='addNew'>
        <div id='addAula' class='add-container'>
            <h1 class='title-add'>Nova aula</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Turma</h3>
                    <select id='turmaAdd'>
                        <option value=''>Nenhuma turma</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Descrição</h3>
                    <input id='descricaoAdd'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Data</h3>
                    <input id='dataAdd' type='date'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("turmas/cadastrar/aula", {
                    turma: turmaAdd.value,
                    descricao: descricaoAdd.value,
                    data: (dataAdd.valueAsNumber / 1000)
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>
    <?php } ?>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Aulas</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead id='headList'></thead>
            <tbody id='tabList'></tbody>
        </table>

    </div>
    
    
        
    <script>
        fetch("../sys/api/turmas/get/turmas")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            
            for(let i of e.mensagem){
                turmaAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome} - ${i.categoria}</option>
                `;
            }
        })

        startPage('aulas');
    </script>
</body>
</html>