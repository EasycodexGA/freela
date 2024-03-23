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
    <h1 class='title-header'>Configurações</h1>

    <div class='inps-out'>
        <div class='infs-conf'>
            <h1>Nome</h1>
            <input type="text" disabled id="nameGet" placeholder="Carregando..." class='inpProfile'/>
        </div>
        <div class='infs-conf'>
            <h1>Nova senha</h1>
            <input type="text" id="passwordGet" placeholder="Nova senha" class='inpProfile'/>
        </div>
        <div class='infs-conf'>
            <h1>Email</h1>
            <input type="text" id="emailGet" placeholder="Carregando..." class='inpProfile'/>
        </div>
        <div class='infs-conf'>
            <h1>CPF</h1>
            <input type="text" disabled id="cpfGet" placeholder="Carregando..." class='inpProfile'/>
        </div>
        <div class='infs-conf'>
            <h1>Nascimento</h1>
            <input type="text" disabled id="nascimentoGet" placeholder="Carregando..." class='inpProfile'/>
        </div>
        <div class='infs-conf'>
            <h1>Tipo</h1>
            <input type="text" disabled id="typeGet" placeholder="Carregando..." class='inpProfile'/>
        </div>
        <?php if(uniqueLevel($__TYPE__, 2)){ ?>
            <div class='infs-conf'>
                <h1>Titularidade</h1>
                <input type="text" disabled id="titularidadeGet" placeholder="Carregando..." class='inpProfile'/>
            </div>
        <?php } ?>
    </div>
    
    <?php if(uniqueLevel($__TYPE__, 2)){ ?>
        <input type='file' id='imageAdd' accept="image/png, image/jpeg"/>
        <button onclick='trocarImg()'>Trocar imagem</button>

        <input type='file' id='arquivoAdd' accept="application/pdf"/>
        <button onclick='novocv()'>Enviar curriculo</button>

        <script>
            const trocarImg = async () => {
                let file = imageAdd.files[0];
                if(!file) return;
                let base64 = await getBase64(file);

                addNewData("usuarios/perfil/trocarImg", {
                    image: base64
                })
            }

            const novocv = async () => {
                let file = arquivoAdd.files[0];
                if(!file) return;
                let base64 = await getBase64(file);
                addNewData("usuarios/perfil/novoCV", {
                    arquivo: base64
                })
            }
        </script>
    <?php } ?>

    <script>
        fetch("../sys/api/usuarios/get/me")
        .then(e=>e.json())
        .then(e=>{
            console.log(e);

            let data = e.mensagem;

            cpfGet.value        = data.cpf ? data.cpf : "Nenhum";
            typeGet.value       = data.type ? data.type : "Nenhum";
            nameGet.value       = data.nome ? data.nome : "Nenhum";
            emailGet.value      = data.email ? data.email : "Nenhum";
            nascimentoGet.value = data.nascimento ? data.nascimento : "Nenhum";

            <?php if(uniqueLevel($__TYPE__, 2)){ ?>
                titularidadeGet.value = data["0"].titularidade;
            <?php } ?>

            newMsg({
                mensagem: "fethcado, katiau",
                response: "aguardando"
            })
        })
    </script>

    <a href="../sys/sair">Sair</a>
</body>
</html>