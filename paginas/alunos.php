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
        <div class='add-container' id='detailContainer'></div>
    </div>

    <div id='verMaisDiv'></div>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div id='headerIn' class='header-in'>
            <button onclick='openAdd(addAluno)' class='funcBt'>+ Adicionar aluno</button>
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
    <?php if(requireLevel($__TYPE__, 2)){ ?>
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
    </script>
    <?php } ?>
    <script src="../js/class.js"></script>
    <script>
        const file = new Alunos(<?php echo $__TYPE__; ?>);
    </script>
    <script src="../js/func.js" defer></script>
</body>
</html>