<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$categorias  = scapeString($__CONEXAO__, $json->categorias);
$categorias = setNum($categorias);
$decCategorias = decrypt($categorias);
echo $categorias;
echo $decCategorias;
$_query_ = mysqli_query($__CONEXAO__, "select * from categorias where id='$decCategorias'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome   = $dados["nome"];
    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"            => $decCategorias,
        "nome"          => $nome,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);