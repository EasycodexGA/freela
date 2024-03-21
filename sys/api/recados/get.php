<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$_query_ = mysqli_query($__CONEXAO__, "select * from recados where from='$__ID__'");

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