<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turma = scapeString($__CONEXAO__, $json->turma);
$turma = setNum($turma);

$_query_ = mysqli_query($__CONEXAO__, "select * from aulas where turma=$turma");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $data       = $dados["data"];
    
    $arr = array(
        "id"        => $dados["id"], 
        "data"      => $data,
        "_name"     => "aulas"
    );
    array_push($array, $arr);
}

endCode($array, true);