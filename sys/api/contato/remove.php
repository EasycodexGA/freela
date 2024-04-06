<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$request = file_get_contents('php://input');
$json = json_decode($request);

$id   = scapeString($__CONEXAO__, $json->id);

$id   = setNum($id);

checkMissing(
    array(
        $id
    )
);

$id = decrypt($id);

mysqli_query($__CONEXAO__, "delete from contatos where id='$id'");

endCode("Removido com sucesso!", true);