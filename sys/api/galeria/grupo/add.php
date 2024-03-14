<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome  = scapeString($__CONEXAO__, $json->nome);

$nome   = setNoXss($nome);

checkMissing(
    array(
        $nome,
    )
);

$check = mysqli_query($__CONEXAO__, "select nome from grupoimagem where nome='$nome'");

if(mysqli_num_rows($check) > 0){
    endCode("Já existe um grupo com esse nome", false);
}

mysqli_query($__CONEXAO__, "insert into grupoimagem (nome) values ('$nome')");

endCode("Sucesso ao criar!", true);