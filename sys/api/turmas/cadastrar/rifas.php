<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$qt         = scapeString($__CONEXAO__, $json->qt);
$nome       = scapeString($__CONEXAO__, $json->nome);
$data       = scapeString($__CONEXAO__, $json->data);
$premios    = scapeString($__CONEXAO__, $json->premios);
$descricao  = scapeString($__CONEXAO__, $json->desc);

$qt         = setNum($qt);
$nome       = setNoXss($nome);
$data       = setNum($data);
$descricao  = setNoXss($descricao);

checkMissing(
    array(
        $qt,
        $nome,
        $data,
        $descricao
    )
);

$data = decrypt($data);

if($data < time() - (86400 * 2)){
    endCode("Essa data já passou!", false);
}

$getRifa = mysqli_query($__CONEXAO__, "select id from rifas where nome='$nome' and data='$data'");

if(mysqli_num_rows($getRifa) > 0){
    endCode("Já existe uma rifa com esses dados.", false);
}

mysqli_query($__CONEXAO__, "insert into eventos (nome, data, descricao, premios, qt, created) values ('$nome','$data', '$descricao', '$premios', '$qt', '$__TIME__')");

endCode("Sala criada com sucesso", true);