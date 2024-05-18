<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $data       = $dados["data"];
    $status     = $dados["active"]; 
    $status     = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $dados["id"], 
        "nome"      => $nome,
        "data"      => $data,
        "status"    => $status,
        "_name"     => "eventos"
    );
    array_push($array, $arr);
}

endCode($array, true);