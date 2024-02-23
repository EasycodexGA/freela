<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turmaicat  = scapeString($__CONEXAO__, $json->turma);
$descricao  = scapeString($__CONEXAO__, $json->descricao);
$data       = scapeString($__CONEXAO__, $json->data);

$turmaicat  = explode("#", $turmaicat);
$turma      = $turmaicat[0];
$categoria  = $turmaicat[1];


$turma      = setNoXss($turma);
$categoria  = setNoXss($categoria);
$descricao  = setNoXss($descricao);
$data       = setNum($data);

checkMissing(
    array(
        $turma,
        $categoria,
        $data,
        $descricao
    )
);

endCode($categoria, false);

$checkCat = mysqli_query($__CONEXAO__, "select id from categorias where nome='$categoria'");

if(mysqli_num_rows($checkCat) == 0){
    endCode("Não existe essa categoria.", false);
}

$data = decrypt($data);

$getDatas = mysqli_query($__CONEXAO__, "select id from aulas where turma='$turma' and data='$data'");

if(mysqli_num_rows($getDatas) > 0){
    endCode("Já existe uma aula para este dia.", false);
}

mysqli_query($__CONEXAO__, "insert into aulas (turma, descricao, data, categoria) values ('$turma', '$descricao', '$data', '$categoria')");

endCode("Aula criada com sucesso", true);