<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$type  = scapeString($__CONEXAO__, $json->type);

checkMissing(
    array(
        $type
    )
);

$pode = array("users", "turmas", "categorias")

if(!in_array($pode, $type)){
    endCode("Pesquisa inválida.", false);
}

if($type == "users"){
    $query = mysqli_query($__CONEXAO, "select active from $type");
}