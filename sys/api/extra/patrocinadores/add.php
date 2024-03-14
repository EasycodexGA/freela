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

if (substr($base64Image, 0, 5) === 'data:') {
    $pos  = strpos($base64Image, ';base64,');
    if ($pos === false) {
        endCode("Código de imagem inválido", false);
        return;
    } else {
        $type = substr($base64Image, 5, $pos - 5);
        if (!in_array($type, ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'])) {
            endCode("Formato de imagem inválido", false);
            return;
        }

        $imageData = substr($base64Image, $pos + 8);
        $imageData = base64_decode($imageData);

        if (!$imageData) {
            endCode("Decodificação de base64 falhou", false);
            return;
        }
    }
} else {
    endCode("Código de imagem inválido", false);
    return;
}

$novoNome   = "i$__TIME__$__CODE__." . ($type === 'image/jpeg' ? 'jpg' : substr($type, 6));

$completo = "$caminho/$novoNome";

// Verifique se a imagem foi salva corretamente
if (file_put_contents($completo, $imageData)) {
    endCode("Sucesso no upload! $completo", true);
} else {
    endCode("Erro ao salvar imagem", false);
}