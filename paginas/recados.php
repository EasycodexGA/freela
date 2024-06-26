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
    <div class='bodyin'>
    <div class='header'>
        <h1 class='title-header'>Recados</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </div>
    <div id='addNewAula'></div>
    <div id='details'>
        <div class='add-container' id='detailContainer'></div>
    </div>

    <?php if(requireLevel($__TYPE__, 2)){ ?>
        <div class='extra'>
            <h1 class='title-header'>Enviar recados</h1>
            <div class='header-in'>
                <?php if(requireLevel($__TYPE__, 3)){ ?>
                    <button onclick='openAdd(addRecadoGeral)' class='funcBt'>+ Para: Todos</button>
                <?php } ?>
                <button onclick='openAdd(addRecadoEquipe)' class='funcBt'>+ Para: Equipe</button>
                <button onclick='openAdd(addRecadoTurma)' class='funcBt'>+ Para: Turma</button>
                <button onclick='openAdd(addRecadoAluno)' class='funcBt'>+ Para: Aluno</button>
            </div>
        </div>
    
        <div id='addNew'>
            <div id='addRecadoAluno' class='add-container'>
                <h1 class='title-add'>Novo reacado - Aluno</h1>
                <div class='inps-add'>
                    <div class='inp-add-out'>
                        <h3>Título</h3>
                        <input id='nomeAssAdd' type='text' placeholder='Assinaturas'/>
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
                        <h3>Até</h3>
                        <input id='horario2Add' type='date'/>
                    </div>
                </div>
                <div class='out-bt-sv'>
                    <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                    <button onclick='addNewData("recados/add", {
                        title: nomeAssAdd.value,
                        desc: descricaoAdd.value,
                        time: (horario2Add.valueAsNumber / 1000),
                        type: 1,
                        to: alunoAdd.value
                    })' class='btn-add'>Salvar</button>
                </div>
            </div>
            <div id='addRecadoTurma' class='add-container'>
                <h1 class='title-add'>Novo reacado - Turma</h1>
                <div class='inps-add'>
                    <div class='inp-add-out'>
                        <h3>Título</h3>
                        <input id='nomeAss2Add' type='text' placeholder='Assinaturas'/>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Descrição</h3>
                        <input id='descricao2Add' type='text' placeholder='Trazer assinatura...'/>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Turma</h3>
                        <select id='turmaAdd'>
                            <option>Nenhuma turma selecionada</option>
                        </select>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Até</h3>
                        <input id='horario3Add' type='date'/>
                    </div>
                </div>
                <div class='out-bt-sv'>
                    <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                    <button onclick='addNewData("recados/add", {
                        title: nomeAss2Add.value,
                        desc: descricao2Add.value,
                        time: (horario3Add.valueAsNumber / 1000),
                        type: 2,
                        to: turmaAdd.value
                    })' class='btn-add'>Salvar</button>
                </div>
            </div>
            <div id='addRecadoEquipe' class='add-container'>
                <h1 class='title-add'>Novo reacado - Equipe</h1>
                <div class='inps-add'>
                    <div class='inp-add-out'>
                        <h3>Título</h3>
                        <input id='nomeAss4Add' type='text' placeholder='Assinaturas'/>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Descrição</h3>
                        <input id='descricao4Add' type='text' placeholder='Trazer assinatura...'/>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Equipe</h3>
                        <select id='equipeAdd'>
                            <option>Nenhuma turma selecionado</option>
                        </select>
                    </div>
                    <div class='inp-add-out'>
                        <h3>Até</h3>
                        <input id='horario4Add' type='date'/>
                    </div>
                </div>
                <div class='out-bt-sv'>
                    <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                    <button onclick='addNewData("recados/add", {
                        title: nomeAss4Add.value,
                        desc: descricao4Add.value,
                        time: (horario4Add.valueAsNumber / 1000),
                        type: 4,
                        to: equipeAdd.value
                    })' class='btn-add'>Salvar</button>
                </div>
            </div>
            <?php if(requireLevel($__TYPE__, 2)){ ?>
                <div id='addRecadoGeral' class='add-container'>
                    <h1 class='title-add'>Novo reacado - Geral</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Título</h3>
                            <input id='nomeAssXAdd' type='text' placeholder='Assinaturas'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Descrição</h3>
                            <input id='descricaoXAdd' type='text' placeholder='Trazer assinatura...'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Até</h3>
                            <input id='horarioXAdd' type='date'/>
                        </div>
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='addNewData("recados/add", {
                            title: nomeAssXAdd.value,
                            desc: descricaoXAdd.value,
                            time: (horarioXAdd.valueAsNumber / 1000),
                            type: 3,
                        })' class='btn-add'>Salvar</button>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>

    <div class="list">
        <div class="header-list-out">
            <h1 class="title-header">Recados</h1>
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
                if(i.status == "active"){
                    turmaAdd.innerHTML += `
                        <option value='${i.id}'>${i.nome} - ${i.categoria}</option>
                    `;
                }
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))

        fetch("../sys/api/usuarios/get/alunos")
        .then(e => e.json())
        .then(e=> {
            for(let i of e.mensagem){
                if(i.status == "active"){
                    alunoAdd.innerHTML += `
                        <option value='${i.id}'>${i.nome} - ${i.email}</option>
                    `;
                }
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))

        fetch("../sys/api/turmas/get/equipes")
        .then(e => e.json())
        .then(e=> {
            for(let i of e.mensagem){
                if(i.status == "active"){
                    equipeAdd.innerHTML += `
                        <option value='${i.id}'>${i.nome}</option>
                    `;
                }
            }
        })
        .catch(e=>newMsg({
            mensagem: "Ocorreu algum erro, contate o administrador",
            response: false
        }))
    </script>

    <script src="../js/class.js"></script>
    <script>const file = new Recados(<?php echo $__TYPE__; ?>);</script>
    <script src="../js/func.js" defer></script>
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">moontis.com</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu Vôlei - Recados - T: <?php echo $__TYPE__; ?>&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
    <script src="https://whos.amung.us/pingjs/?k=totalmoontis&t=Partiu Vôlei - Recados - T: <?php echo $__TYPE__; ?>&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>

    </div>
</body>
</html>