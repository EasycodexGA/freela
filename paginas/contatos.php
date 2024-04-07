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
            <h2 class='sub-header'><span id="active">0</span> Contatos</h2>
        </div>
    </header>

    <div id="contatos">

    </div>

    <script src="../js/func.js"></script>
    <script>
        fetch("../sys/api/contato/get")
        .then(e=>e.json())
        .then(e=>{
            console.log(e)
            if(e.mensagem.length == 0){
                contatos.innerHTML = "<p>Nenhum contato</p>";
                return;
            }

            active.innerText = e.mensagem.length;

            for(let res of e.mensagem){
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
                        <button onclick='removeContato(${res.id})'>Remover</button>
                    </div>
                `;
            }

        })

        function removeContato(e){
            fetch("../sys/api/contato/remove", {
                method: "POST",
                body: JSON.stringify({
                    id: e
                })
            })
            .then(e=>e.json())
            .then(e=>{
                if(e.response){
                    window.location.reload();
                }
                newMsg(e)
            })
        }
    </script>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu Vôlei - Contatos - T: <?php echo $__TYPE__; ?>&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>

</body>
</html>