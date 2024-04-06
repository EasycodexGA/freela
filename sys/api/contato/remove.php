<?php
include '../../conexao.php';

// justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id   = scapeString($__CONEXAO__, $json->telefone);

$id   = setNum($id);

checkMissing(
    array(
        $id
    )
);

$check = mysqli_query($__CONEXAO__, "delete from contatos where id='$id'");

endCode("Removido com sucesso!", true);