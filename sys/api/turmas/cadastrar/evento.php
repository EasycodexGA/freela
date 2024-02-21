<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome       = scapeString($__CONEXAO__, $json->nome);
$data       = scapeString($__CONEXAO__, $json->data);
$turma      = scapeString($__CONEXAO__, $json->turma);
$descricao  = scapeString($__CONEXAO__, $json->descricao);

$nome       = setNoXss($nome);
$data       = setNum($data);
$turma      = setNum($turma);
$descricao  = setNoXss($descricao);

checkMissing(
    array(
        $nome,
        $data,
        $turma,
        $descricao
    )
);

$data = decrypt($data);

if($data < time()){
    endCode("Essa data já passou!", false);
}

$turmaDec = decrypt($turma);

$getTurma = mysqli_query($__CONEXAO__, "select * from turmas where id='$turmaDec'");

if(mysqli_num_rows($getTurma) < 1){
    endCode("Turma inválida.", false);
}


$getEvento = mysqli_query($__CONEXAO__, "select * from eventos where nome='$nome' and turma='$turma' and data='$data'");

if(mysqli_num_rows($getEvento) > 0){
    endCode("Já existe um evento com esses dados.", false);
}

mysqli_query($__CONEXAO__, "insert into eventos (nome, turma, data, descricao) values ('$nome', '$turma','$data', '$descricao')");


endCode("Sala criada com sucesso", true);