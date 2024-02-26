<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$categorias  = scapeString($__CONEXAO__, $_GET['id']);
$categorias = setNum($categorias);
$decCategorias = decrypt($categorias);
$_query_ = mysqli_query($__CONEXAO__, "select * from categorias where id='$decCategorias'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome   = decrypt($dados["nome"]);
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