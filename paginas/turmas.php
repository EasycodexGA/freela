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
        <h1 class='title-header'>Geral - Turmas</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <div id='details'>
        <div class='add-container' id='detailContainer'></div>
    </div>


    <?php if(requireLevel($__TYPE__, 2)){ ?>
    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
        <?php if(requireLevel($__TYPE__, 3)){ ?>
            <button onclick='openAdd(addTurma)' class='funcBt'>+ Adicionar turma</button>
        <?php } ?>
        </div>
    </div>

    <div id='addNew'>
    <?php if(requireLevel($__TYPE__, 3)){ ?>

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
        <?php } ?>
    </div>

    <div id='addNewAula'>
        <div id='addAula' class='add-container'>
            <h1 class='title-add'>Nova aula</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Descrição</h3>
                    <input id='descricaoAdd' type='text' placeholder='Vôlei de praia'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Data</h3>
                    <input id='dataAddAula' type='date'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Chamada</h3>
                    <button id='verPresencaBt' class='btn-add'>Ver chamada</button>
                </div>
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAddAula()'>Fechar</button>
                <button onclick='addNewData("turmas/cadastrar/aula", {
                    descricao: descricaoAdd.value,
                    presenca: getPresenca("alunos"),
                    data: (dataAddAula.valueAsNumber / 1000),
                    turma: file.idDetail
                })' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>
    
    <?php } else { ?>
    <div id='addNew'></div>
    <div id='addNewAula'></div>
    <?php } ?>
    
    <div id='verMaisDiv'></div>
    
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
    <div id="headerIn"></div>

    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <script>
        fetch("../sys/api/usuarios/get/categorias")
        .then(e=>e.json())
        .then(e=>{
            for(let i of e.mensagem){
                categoriaAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome}</option>
                `;
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))

        fetch("../sys/api/usuarios/get/profissionais")
        .then(e=>e.json())
        .then(e=>{
            for(let i of e.mensagem){
                profissionalAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome} - ${i.titularidade}</option>
                `;
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    </script>
    <?php } ?>
    <script src="../js/class.js"></script>
    <script>const file = new Turmas(<?php echo $__TYPE__; ?>);</script>
    <script src="../js/func.js" defer></script>
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">moontis.com</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
</body>
</html>