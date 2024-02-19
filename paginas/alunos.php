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
    <link rel="stylesheet" href="../style/main.css">
    <link rel="stylesheet" href="../style/paginas.css">
    <link rel="shortcut icon" href="../img/prefeitura.png" type="image/x-icon">
</head>
<body onload="getActInact('usersalunos')">
    <header>
        <h1 class='title-header'>Geral - Alunos</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <div class='extra'>
        <h1 class='title-header'>Funções</h1>
        <div class='header-in'>
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
            </div>
            <button onclick='addNewData("usuarios/cadastrar/aluno", {
                nome: nomeAdd.value,
                turma: turmaAdd.value,
                nascimento: (nascimentoAdd.valueAsNumber / 1000),
                email: emailAdd.value,
                cpf: cpfAdd.value
            })' class='btn-add'>Salvar</button>
        </div>
    </div>

    <script>
        fetch("../sys/api/turmas/get/turmas")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            
            for(let i of e.mensagem){
                categoriaAdd.innerHTML += `
                    <option value='${i.id}'>${i.nome} - ${i.categoria}</option>
                `;
            }
        })
    </script>

    <script src="../js/func.js"></script>
    
</body>
</html>