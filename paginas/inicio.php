<?php
include "../sys/conexao.php";
$patrocinadores = "";

$getPat = mysqli_query($__CONEXAO__, "select * from patrocinadores");

while($dados = mysqli_fetch_array($getPat)){
    $id   = $dados["id"];
    $nome   = $dados["nome"];
    $img    = $dados["img"];
    $nome   = decrypt($nome);
    $img    = decrypt($img);

    $extra = $__TYPE__ == 3 ? "onclick='addNewData(`extra/patrocinadores/remove`,{id:$id})' class='excluir-pat'" : "";
    $patrocinadores .= "<img $extra src='$__WEB__/imagens/patrocinadores/$img' alt='$nome'/>";
}
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
<div class='bodyin'>
    <div class='header'>
        <h1 class='title-header'>Inicio</h1>
    </div>
    <div class='infos'>
        <h1 class='title-header'>Objetivo do projeto</h1>
        <p>
            Projeto desportivo que mira, além da inclusão social, o rendimento desportivo individual e coletivo. Em sua essência, o PROJETO POMERODE VOLEIBOL 2024, visa  oportunizar às crianças e jovens do município de Pomerode o contato com a modalidade VOLEIBOL de forma gratuita e em um ambiente saudável e integrado com a sociedade.
        </p>
    </div>

    <div class='infos'>
        <h1 class='title-header'>Patrocinadores</h1>

        <div class='patrocinadores'>
            <?php echo ($patrocinadores ? $patrocinadores : "Ainda não há patrocinadores"); ?>
        </div>
    </div>

    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <div class='extra'>
        <div class='header-in'>
            <button onclick='openAdd(addPatrocinador)' class='funcBt'>+ Adicionar patrocinador</button>
        </div>
    </div>
    <div id='details'>
    </div>
    <div id='addNew'>
        <div id='addPatrocinador' class='add-container'>
            <h1 class='title-add'>Novo patrocinador</h1>

            <div class='inps-add'>
                <div class='inp-add-out'>
                    <h3>Nome</h3>
                    <input id='nomeAdd' type='text' placeholder='Marca patrocinadora'/>
                </div>
                <div class='inp-add-out'>
                    <h3>Imagem</h3>
                    <input id='imageAdd' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                </div>
                
            </div>
            <div class='out-bt-sv'>
                <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                <button onclick='convert64()' class='btn-add'>Salvar</button>
            </div>
        </div>
    </div>

    <?php } ?>

    <div style="display:flex; gap: 30px; align-items: center;">
        <div class='infos'>
            <h1 class='title-header'>Contato</h1>
            <p>
                <span>Prof. Luciano Menegaz</span>
                <span>F. (48) 99806 0667</span>
                <span>lucianor.menegaz@gmail.com</span>
            </p>
        </div>
        <div style="width: 125px; aspect-ratio: 1; position: relative; border-radius: 100px; overflow: hidden;">
            <img style="position: absolute; width: 100%; height: 100%; object-fit: cover;" src='../img/luciano.jpg'>
        </div>
    </div>

    <div class='infos'>
        <h1 class='title-header'>Endereço</h1>
        <p>
            <span>Ginasio Ralf Knaesel</span>
            <span>Secretaria de Eventos, Esporte e Lazer</span>
            <span>Endereço: Av. 21 de Janeiro - 2700</span>
            <span>Pomerode - SC</span>
            <span>Telefone(s): (47) 3387-2612</span>
            <span>E-mail: seel@pomerode.sc.gov.br</span>
        </p>
    </div>
    <div id="b2xcodeOut">
        <h1 id='b2xcodeIn'>
            Feito com ♥ por <a href="#">moontis.com</a> - © Copyright <?php echo date('Y')?>
        </h1>
    </div>
    </div>
</body>
</html>