<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$image  = scapeString($__CONEXAO__, $json->image);
$grupo  = scapeString($__CONEXAO__, $json->grupo);

$id   = setNum($id);

checkMissing(
    array(
        $id
    )
);
