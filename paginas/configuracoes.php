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
    <h1 class='title-header'>Sua foto</h1>
    
    <?php if(requireLevel($__TYPE__, 2)){ ?>
        <!-- Enviar CV -->
        <!-- trocar imagem  -->
        <input type='file' id='imageAdd' accept="image/png, image/jpeg"/>
        <button onclick='trocarImg()'>Trocar imagem</button>
 
        <input type='file' id='arquivoAdd' accept="application/pdf"/>
        <button onclick='novocv()'>Enviar curriculo</button>

        <script>
            const trocarImg = () => {
                let file = imageAdd.files[0];
                if(!file) return;
                let base64 = await getBase64(file);

                addNewData("usuarios/perfil/trocarImg", {
                    image: base64
                })
            }

            const novocv = () => {
                let file = arquivoAdd.files[0];
                if(!file) return;
                let base64 = await getBase64(file);

                addNewData("usuarios/perfil/novoCV", {
                    arquivo: base64
                })
            }
        </script>
    <?php } ?>
</body>
</html>