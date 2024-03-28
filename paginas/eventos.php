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
</head>
<body>
    <header>
        <h1 class='title-header'>Geral - Eventos</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>
    <div id='addNewAula'></div>
    
    <div id='details'>
        <div class='add-container' id='detailContainer'></div>
    </div>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
            <button onclick='openAdd(addEvento)' class='funcBt'>+ Adicionar evento</button>
        </div>
    </div>

    <?php if(requireLevel($__TYPE__, 2)){ ?>

    <div id='addNew'>
        <div id='addEvento' class='add-container'>
            <h1 class='title-add'>Novo evento</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Vôlei de praia'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Turma</h3>
                    <select id='turmaAdd'>
                        <option value=''>Nenhuma turma</option>
                    </select>
                </div>
                <div class='inp-add-out'>
                    <h3>Data</h3>
                    <input id='dataAdd' type='date'/>
                </div>
                <div class='inp-add-out' style="width: calc(100%)">
                    <h3>Descrição</h3>
                    <input id='descricaoAdd' type='text' placeholder='Ex: Campeonato de vôlei estadual, apenas jogadores Sub x, trazer autorização assinada.'/>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='addNewData("turmas/cadastrar/evento", {
                    nome: nomeAdd.value,
                    turma: turmaAdd.value,
                    data: (dataAdd.valueAsNumber / 1000),
                    descricao: descricaoAdd.value

                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>
    <?php } else { ?>
    <div id='addNew'></div>
    <?php } ?>

    <div id='verMaisDiv'></div>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Eventos</h1>
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
    <script>const file = new Eventos(<?php echo $__TYPE__; ?>);</script>
    <script src="../js/func.js"></script>
    
</body>
</html>