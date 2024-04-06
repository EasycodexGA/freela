<?php
include "../sys/conexao.php";
justLog($__EMAIL__, $__TYPE__, 3);
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
        <h1 class='title-header'>Geral - Contatos</h1>
        <div class='header-in'>
            <h2 class='sub-header'><span id="active">0</span> Ativos</h2>
            <h2 class='sub-header'><span id="inactive">0</span> Inativos</h2>
        </div>
    </header>

    <div id="contatos">

    </div>

    <script>
        fetch("../sys/api/contato/get")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            if(e.mensagem.length == 0){
                contatos.innerHTML = "<p>Nenhum contato</p>";
                return;
            }

            e.mensagens.map(res=>{
                contatos.innerHTML += `
                    <div class='contato'>
                        <div class='contatoin'>
                            <h1>Nome</h1>
                            <p>${res.nome}</p>
                        </div>
                        <div class='contatoin'>
                            <h1>Email</h1>
                            <p>${res.email}</p>
                        </div>
                        <div class='contatoin'>
                            <h1>Telefone</h1>
                            <p>${res.telefone}</p>
                        </div>
                    </div>
                `;
            })
        })
    </script>
</body>
</html>