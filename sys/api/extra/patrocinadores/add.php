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

$caminho = "../../../../imagens/patrocinadores";

// Verifique se o caminho existe antes de tentar criar o diretório
if (!file_exists($caminho)) {
    if (!mkdir($caminho, 0777, true)) {
        endCode("Erro ao criar o diretório", false);
        return;
    }
}

// Verifique se a imagem está no formato base64
if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
    $imageData = substr($base64Image, strpos($base64Image, ',') + 1);
    $type = strtolower($type[1]); // jpg, png, gif

    if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
        endCode("Formato de imagem inválido", false);
        return;
    }

    $imageData = base64_decode($imageData);

    if ($imageData === false) {
        endCode("Decodificação de base64 falhou", false);
        return;
    }
} else {
    endCode("Código de imagem inválido", false);
    return;
}
$novoNome   = "i$__TIME__$__CODE__.$type";

$completo = "$caminho/$novoNome";

// Verifique se a imagem foi salva corretamente
if (file_put_contents($completo, $imageData)) {
    endCode("Sucesso no upload! $completo", true);
} else {
    endCode("Erro ao salvar imagem", false);
}