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

$arquivo  = scapeString($__CONEXAO__, $json->arquivo);

$caminho = "../../../../arquivos/curriculos";

if (!file_exists($caminho)) {
    if (!mkdir($caminho, 0777, true)) {
        endCode("Erro ao criar o diretório", false);
        return;
    }
}

$parts = explode(',', $arquivo);
if (count($parts) !== 2) {
    endCode("Código de arquivo inválido", false);
    return;
}

$formatPart = $parts[0];
$arquivoData = base64_decode($parts[1]);

if ($arquivoData === false) {
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

$getCVFromUser = mysqli_query($__CONEXAO__, "select curriculo from users where id='$__ID__'");

$assoc = mysqli_fetch_assoc($getCVFromUser);
$cvUser = decrypt($assoc["curriculo"]);

if (file_put_contents($completo, $arquivoData)) {
    unlink("$caminho/$cvUser");
    mysqli_query($__CONEXAO__, "update users set imagem='$novoNomeEnc' where id='$__ID__'") or endCode("Erro ao salvar imagem", false);
    endCode("Sucesso no upload!", "enviado");
} else {
    endCode("Erro ao salvar imagem", false);
}
