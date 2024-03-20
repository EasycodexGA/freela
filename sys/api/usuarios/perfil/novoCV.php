<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

if(!uniqueLevel($__TYPE__, 2)){
    endCode("Você não pode alterar o currículo.", false);
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$image  = scapeString($__CONEXAO__, $json->image);

$caminho = "../../../../arquivos/curriculos";

if (!file_exists($caminho)) {
    if (!mkdir($caminho, 0777, true)) {
        endCode("Erro ao criar o diretório", false);
        return;
    }
}

$parts = explode(',', $image);
if (count($parts) !== 2) {
    endCode("Código de imagem inválido", false);
    return;
}

$formatPart = $parts[0];
$imageData = base64_decode($parts[1]);

if ($imageData === false) {
    endCode("Decodificação de base64 falhou", false);
    return;
}

$format = str_replace(['data:application/', ';base64'], '', $formatPart);
if (!in_array($format, ['pdf'])) {
    endCode("Formato não é PDF.", false);
    return;
}

$novoNome   = "i$__TIME__$__CODE__.$format";
$completo = "$caminho/$novoNome";
$novoNomeEnc = encrypt($novoNome);

$startTime = microtime(true);

$imageS = imagecreatefromstring($imageData);

$getImgFromUser = mysqli_query($__CONEXAO__, "select curriculo from users where id='$__ID__'");

$assoc = mysqli_fetch_assoc($getImgFromUser);
$cvUser = decrypt($assoc["curriculo"]);

if (imagejpeg($imageS, $completo, 60)) {
    unlink("$caminho/$cvUser");
    mysqli_query($__CONEXAO__, "update users set imagem='$novoNomeEnc' where id='$__ID__'") or endCode("Erro ao salvar imagem", false);
    endCode("Sucesso no upload!", "enviado");
} else {
    endCode("Erro ao salvar imagem", false);
}
