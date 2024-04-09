<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome       = scapeString($__CONEXAO__, $json->nome);
$data       = scapeString($__CONEXAO__, $json->data);
$descricao  = scapeString($__CONEXAO__, $json->descricao);

$nome       = setNoXss($nome);
$data       = setNum($data);
$descricao  = setNoXss($descricao);

checkMissing(
    array(
        $nome,
        $data,
        $descricao
    )
);

$data = decrypt($data);

if($data < time() - (86400 * 2)){
    endCode("Essa data já passou!", false);
}

$getEvento = mysqli_query($__CONEXAO__, "select id from eventos where nome='$nome' and data='$data'");

if(mysqli_num_rows($getEvento) > 0){
    endCode("Já existe um evento com esses dados.", false);
}

mysqli_query($__CONEXAO__, "insert into eventos (nome, data, descricao, created) values ('$nome','$data', '$descricao', '$__TIME__')");

endCode("Sala criada com sucesso", true);