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

if(!file_exists($caminho)) {
    mkdir($caminho, 0777, true);
}

$extensao = 'jpg';
if (strpos($base64Image, 'image/png') !== false) {
    $extensao = 'png';
}

$novoNome   = "i$__TIME__$__CODE__.$extensao";
$completo   = "$caminho/$novoNome";

if (file_put_contents($completo, $imageData)) {
    endCode("Sucesso no upload! $completo", true);
} else {
    endCode("Erro ao salvar imagem", false);
}