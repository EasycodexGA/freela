<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$_query_ = mysqli_query($__CONEXAO__, "select * from categorias order by nome desc");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $id = $dados['id'];
    $nome = $dados["nome"];
    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from turmas where categoria='$id'");

    $arr = array(
        "id"        => $id, 
        "nome"      => decrypt($nome), 
        "turmas"    => mysqli_num_rows($query),
        "status"    => $status,
        "_name"     => "categorias"
    );

    array_push($array, $arr);
}

endCode($array, true);