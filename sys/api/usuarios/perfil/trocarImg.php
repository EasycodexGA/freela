<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

if(!requireLevel($__TYPE__, 2)){
    exit;
}

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$image  = scapeString($__CONEXAO__, $json->image);

$caminho = "../../../../imagens/perfil";

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

$format = str_replace(['data:image/', ';base64'], '', $formatPart);
if (!in_array($format, ['jpeg', 'jpg', 'gif', 'png', 'webp'])) {
    endCode("Formato de imagem inválido", false);
    return;
}

if ($format === 'jpeg') {
    $format = 'jpg';
}

$novoNome   = "i$__TIME__$__CODE__.$format";
$completo = "$caminho/$novoNome";
$novoNomeEnc = encrypt($novoNome);

$startTime = microtime(true);

$imageS = imagecreatefromstring($imageData);

$getImgFromUser = mysqli_query($__CONEXAO__, "select imagem from users where id='$__ID__'");

if(mysqli_num_rows($getImgFromUser) > 0){
    $assoc = mysqli_fetch_assoc($getImgFromUser);
    $imgUser = decrypt($assoc["imagem"]);
}

if (imagejpeg($imageS, $completo, 60)) {
    unlink("$caminho/$imgUser");
    mysqli_query($__CONEXAO__, "update users set imagem='$novoNomeEnc' where id='$__ID__'") or endCode("Erro ao salvar imagem", false);
    endCode("Sucesso no upload!", "enviado");
} else {
    endCode("Erro ao salvar imagem", false);
}
