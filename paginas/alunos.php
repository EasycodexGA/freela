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
    <link rel="stylesheet" href="../style/paginas.css">
    <link rel="shortcut icon" href="../img/prefeitura.png" type="image/x-icon">
    <script src="../js/func.js"></script>
</head>
<body>
    <header>
        <h1 class='title-header'>Geral - Alunos</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>
    <div id='addNewAula'></div>

    <div id='details'>
        <div class='add-container'>
            <h1 class='title-add'>Detalhes</h1>
            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <p id='nomeGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Email</h3>
                    <p id='emailGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>CPF</h3>
                    <p id='cpfGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Nascimento</h3>
                    <p id='nascimentoGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Presenças</h3>
                    <p id='presencasGet'>-- -- --</p>
                </div>
                <div class='inp-add-out'>
                    <h3>Faltas</h3>
                    <p id='faltasGet'>-- -- --</p>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button id='btnRemove' class='btn-add'>Excluir</button>
                <button onclick='javascript:void(0)' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addAluno)' class='funcBt'>+ Adicionar aluno</button>
            <button onclick='openAdd(addRecado)' class='funcBt'>+ Novo recado</button>
        </div>
    </div>
    
    <div id='addNew'>
        <div id='addAluno' class='add-container'>
            <h1 class='title-add'>Novo aluno</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Fulano da silva'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Turma</h3>
                    <select id='turmaAdd'>
                        <option value=''>Nenhuma turma</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Nascimento</h3>
                    <input id='nascimentoAdd' type='date'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Email</h3>
                    <input id='emailAdd' type='text' placeholder='exemplo@gmail.com'/>
                </div>
                <div class='inp-add-out'>
                    <h3>CPF</h3>
                    <input id='cpfAdd' type='text' placeholder='12345678900'/>
                </div>
                <div class='inp-add-out2'>
                    <h3>Lista de espera?</h3>
                    <input id='esperaAdd' type='checkbox'>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("usuarios/cadastrar/aluno", {
                    nome: nomeAdd.value,
                    turma: turmaAdd.value,
                    nascimento: (nascimentoAdd.valueAsNumber / 1000),
                    email: emailAdd.value,
                    cpf: cpfAdd.value,
                    espera: esperaAdd.checked ? true : false
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
        <div id='addRecado' class='add-container'>
            <h1 class='title-add'>Novo reacado</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Título</h3>
                    <input id='nomeAdd' type='text' placeholder='Assinaturas'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Descrição</h3>
                    <input id='descricaoAdd' type='text' placeholder='Trazer assinatura...'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Aluno</h3>
                    <select id='alunoAdd'>
                        <option>Nenhum aluno selecionado</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>De</h3>
                    <input id='horario1Add' type='date'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Até</h3>
                    <input id='horario2Add' type='date'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("", {
                    
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Alunos</h1>
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
            for(let i of e.mensagem){
                turmaAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome} - ${i.categoria}</option>
                `;
            }
        })

        startPage('alunos');
    </script>
</body>
</html>