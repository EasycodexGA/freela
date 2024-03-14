<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome  = scapeString($__CONEXAO__, $json->nome);
$image  = scapeString($__CONEXAO__, $json->image);

$nome   = setNoXss($nome);

checkMissing(
    array(
        $nome,
        $image,
    )
);

$imageData  = base64_decode($base64Image);

$caminho    = "../../../../imagens/patrocinadores";

if(!file_exists(dirname($caminho))) {
    mkdir(dirname($caminho), 0777, true);
}

$extensao = 'jpg';
if (strpos($base64Image, 'image/png') !== false) {
    $extensao = 'png';
}

$novoNome   = "i$__TIME__$__CODE__.$extensao";

file_put_contents("$caminho/$novoNome", $imageData);
endCode("Sucesso no upload! $caminho$novoNome", true);
