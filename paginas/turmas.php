<?php
include "../sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 1);
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
    <header>
        <h1 class='title-header'>Geral - Turmas</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>
    <div id='verMaisDiv'></div>

    <div id='details'>
        <div class='add-container'>
            <h1 class='title-add'>Detalhes</h1>
            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <p id='nomeGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Categoria</h3>
                    <p id='categoriaGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Profissionais - <span id='profissionaisQtGet'>0</span></h3>
                    <p id='profissionaisGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Alunos - <span id='alunosQtGet'>0</span></h3>
                    <p id='alunosGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Horário</h3>
                    <p id='horarioGet'>-- -- --</p>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button id='btnRemove' class='btn-add'>Excluir</button>
                <button id='btnAddAula' class='btn-add' onclick='openAddAula()'>+ Adicionar aula</button>
                <button onclick='javascript:void(0)' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addTurma)' class='funcBt'>+ Adicionar turma</button>
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

    <div id='addNewAula'>
        <div id='addTurma' class='add-container'>
            <h1 class='title-add'>Nova aula</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Descrição</h3>
                    <input id='descricaoAdd' type='text' placeholder='Vôlei de praia'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Presença</h3>
                    <button id='verPresencaBt'>Ver presença</button>
                </div>
                <div class='inp-add-out'>
                    <h3>Horário</h3>
                    <input id='horarioAddAula' type='time'/>
                </div>
            </div>
            <span id='idTurma'></span>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("turmas/cadastrar/aula", {
                    descricao: descricaoAdd.value,
                    presenca: presencaAdd.value,
                    horario: horarioAddAula.valueAsNumber,
                    idTurma: idTurma.value
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>
    
    <?php } else { ?>
        <div id='addNew'></div>
        <div id='addNewAula'></div>
    <?php }?>
    
    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Turmas</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead id='headList'></thead>
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
                    <option value='${i.id}'>${i.nome}</option>
                `;
            }
        })

        fetch("../sys/api/usuarios/get/professores")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            
            for(let i of e.mensagem){
                profissionalAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome} - ${i.titularidade}</option>
                `;
            }
        })

        startPage('turmas');
    </script>
</body>
</html>