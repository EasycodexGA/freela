<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

if(!uniqueLevel($__TYPE__, 2)){
    endCode("Você não pode alterar o currículo.", false);
    exit;
}

$request = file_get_contents('php://input');
$json = json_decode($request);

$what  = scapeString($__CONEXAO__, $json->what);

checkMissing(array(
    $what
));

