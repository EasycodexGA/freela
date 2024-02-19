<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome = $json->$nome;
$nome = strtolower($nome);
$nome = scapeString($__CONEXAO__, $nome);
$nome = setNoXss($nome);
checkMissing(array($nome));

$_query_ = mysqli_query($__CONEXAO__, "select * from categorias where nome='$nome'");

if(mysqli_num_rows($_query_) > 0){
    endCode('Já existe uma categoria com este nome!', false);
}

mysqli_query($__CONEXAO__, "insert into categorias (nome) values ('$nome')")  or die("erro insert");

endCode("Sucesso, categoria criada!", true);