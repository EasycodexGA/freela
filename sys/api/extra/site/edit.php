<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$titulo  = scapeString($__CONEXAO__, $json->titulo);
$image  = scapeString($__CONEXAO__, $json->image);

if(!$titulo and !$image){
    endCode("Altere alguma coisa", false);
}

$titulo   = setNoXss($titulo);

if($image){

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


$novoNome   = "i$__TIME__$__CODE__.$format";

$completo = "$caminho/$novoNome";
$novoNomeEnc = encrypt($novoNome);

$ext = ", banner='$novoNomeEnc'";
} else {
    $ext = "";
}

if (file_put_contents($completo, $imageData)) {
    mysqli_query($__CONEXAO__, "update configs set title='$nome' $ext") or endCode("Erro ao salvar", false);
    endCode("Editado com sucesso!", true);
} else {
    endCode("Erro ao salvar imagem", false);
}