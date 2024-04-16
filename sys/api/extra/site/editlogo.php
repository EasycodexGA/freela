<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$image  = scapeString($__CONEXAO__, $json->image);

if(!$image){
    endCode("Altere a imagem e tente novamente", false);
}

$caminho = "../../../../imagens/website";

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
if (!in_array($format, ['jpeg', 'jpg', 'gif', 'png'])) {
    endCode("Formato de imagem inválido", false);
    return;
}

if ($format === 'jpeg') {
    $format = 'jpg';
}

$novoNome   = "b$__TIME__$__CODE__.$format";
$completo = "$caminho/$novoNome";
$novoNomeEnc = encrypt($novoNome);

// Verifique se a imagem é PNG e processe-a de acordo
if ($format === 'png') {
    $im = imagecreatefromstring($imageData);
    imagesavealpha($im, true);
    imagepng($im, $completo);
    imagedestroy($im);
} else {
    if (!file_put_contents($completo, $imageData)) {
        endCode("Erro ao salvar imagem", false);
    }
}

$rmBanner = mysqli_query($__CONEXAO__, "select logo from configs where id='1'");
$assRmBanner = mysqli_fetch_assoc($rmBanner);
$oldBanner = decrypt($assRmBanner["logo"]);
unlink("$caminho/$oldBanner");

if (file_exists($completo) or !$image) {
    mysqli_query($__CONEXAO__, "update configs set logo='$novoNomeEnc'") or endCode("Erro ao salvar", false);
    endCode("Editado com sucesso!", true);
} else {
    endCode("Erro ao salvar imagem", false);
}
?>
