<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome       = scapeString($__CONEXAO__, $json->nome);
$categoria  = scapeString($__CONEXAO__, $json->categoria);

$nome       = setNoXss($nome);
$categoria  = setNum($categoria);

if(!$nome or !$categoria){
    endCode("Algum dado está faltando", false);
}

$getTurma = mysqli_query($__CONEXAO__, "select * from turmas where nome='$nome' and categoria='$categoria'");

if(mysqli_num_rows($getTurma) > 0){
    endCode("Já existe uma turma com esses dados.");
}

mysqli_query($__CONEXAO__, "insert into turmas (nome, categoria, data) values ('$nome', '$categoria', '$__TIME__')");


endCode("Sala criada com sucesso", false);