<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome = scapeString($__CONEXAO__, $json->nome);
$nome = setNoXss($nome);
checkMissing(array($nome));

mysqli_query($__CONEXAO__, "insert into categorias (nome) values ('$nome')")  or die("erro insert");

endCode("Sucesso, categoria criada!", true);