<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$info1  = scapeString($__CONEXAO__, $json->info1);
$info2  = scapeString($__CONEXAO__, $json->info2);
$info3  = scapeString($__CONEXAO__, $json->info3);

$info1 = setNoXss($info1);
$info2 = setNoXss($info2);
$info3 = setNoXss($info3);

mysqli_query($__CONEXAO__, "update configs set info1='$info1', info2='$info2', info3='$info3'") or endCode("Erro ao salvar", false);
endCode("Editado com sucesso!", true);
