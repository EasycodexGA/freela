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
<body>
    <header>
        <h1 class='title-header'>Geral - Profissionais</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addProfessor)' class='funcBt'>+ Adicionar profissional</button>
        </div>
    </div>

    <div id='addNew'>
        <div id='addProfessor' class='add-container'>
            <h1 class='title-add'>Novo profissional</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Fulano da silva'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Titularidade</h3>
                    <input id='titularidadeAdd' type='text' placeholder='Professor'/>
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
            </div>
            <button onclick='addNewData("usuarios/cadastrar/professor", {
                nome: nomeAdd.value,
                titularidade: titularidadeAdd.value,
                nascimento: (nascimentoAdd.valueAsNumber / 1000),
                email: emailAdd.value,
                cpf: cpfAdd.value
            })' class='btn-add'>Salvar</button>
        </div>
    </div>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Profissionais</h1>
            <input id="searchBar" name="searchBar" placeholder="Pesquisar..">
        </div>
        <table class="content-list">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>email</th>
                    <th>Nascimento</th>
                    <th></th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody id='tabList'></tbody>
        </table>

    </div>
    
    <script src="../js/func.js"></script>
    <script>
        startPage('usuarios/get/professores', 'usersprofessor');
    </script>
    
</body>
</html>