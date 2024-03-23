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
        <input type="text" id="myName" placeholder="Carregando..." class='inpProfile'/>
        <input type="text" id="myEmail" placeholder="Carregando..." class='inpProfile'/>
        <input type="text" id="myCpf" placeholder="Carregando..." class='inpProfile'/>
        <input type="text" id="myNascimento" placeholder="Carregando..." class='inpProfile'/>
        <input type="text" id="myType" placeholder="Carregando..." class='inpProfile'/>
        <?php if(uniqueLevel($__TYPE__, 2)){ ?>
            <input type="text" id="myTitularidade" placeholder="Carregando..." class='inpProfile'/>
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
            console.log(e)
            newMsg({
                mensagem: e.mensagem,
                response: "aguardando"
            })
        })
    </script>

    <a href="../sys/sair">Sair</a>
</body>
</html>