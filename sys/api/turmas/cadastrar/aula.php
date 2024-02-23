<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turma      = scapeString($__CONEXAO__, $json->turma);
$descricao  = scapeString($__CONEXAO__, $json->descricao);
$data       = scapeString($__CONEXAO__, $json->data);

$turma      = setNoXss($turma);
$descricao  = setNoXss($descricao);
$data       = setNum($data);

if(!$nome or !$descricao or $data){
    endCode("Algum dado está faltando", false);
}

$data = decrypt($data);

$getDatas = mysqli_query($__CONEXAO__, "select id from aulas where turma='$turma' and data='$data'");

if(mysqli_num_rows($getDatas) > 0){
    endCode("Já existe uma aula para este dia.", false);
}

mysqli_query($__CONEXAO__, "insert into turmas (turma, descricao, data) values ('$turma', '$descricao', '$data')");

endCode("Aula criada com sucesso", true);