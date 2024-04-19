<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$desc  = scapeString($__CONEXAO__, $json->desc);

$desc = setNoXss($desc);

mysqli_query($__CONEXAO__, "update configs set desc='$desc'") or endCode("Erro ao salvar", false);
endCode("Editado com sucesso!", true);
