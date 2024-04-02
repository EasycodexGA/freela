<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$image  = scapeString($__CONEXAO__, $json->image);
$grupo  = scapeString($__CONEXAO__, $json->grupo);

$grupo   = setNum($grupo);

checkMissing(
    array(
        $grupo
    )
);

$grupo = decrypt($grupo);
$caminho = "../../../../imagens/galeria";

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

// Limit the transfer rate to 600KB per second
$startTime = microtime(true);

// Cria uma imagem a partir dos dados decodificados
$imageS = imagecreatefromstring($imageData);


if (imagejpeg($imageS, $completo, 60)) {
    sleep(250);
    mysqli_query($__CONEXAO__, "insert into imagensgp (img, grupo, time) values ('$novoNomeEnc', '$grupo', '$__TIME__')") or endCode("Erro ao salvar imagem", false);
    endCode("Sucesso no upload!", "enviado");
} else {
    endCode("Erro ao salvar imagem", false);
}
