<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$_query_ = mysqli_query($__CONEXAO__, "select * from rifas");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $valor      = decrypt($dados['valor']);
    $premio     = $dados['premios'];
    $premio     = json_encode($premio);
    endCode($premio, false);
    $img        = $premio[0]->img;

    $query = mysqli_query($__CONEXAO__, "select id from numerorifa where ref='$id'");
    $selected = mysqli_num_rows($query);

    $arr = array(
        "id"    => $dados["id"], 
        "nome"  => $nome,
        "img"   => $img,
        "valor" => $valor,
        "qt"    => $dados['qt'],
        "sel"   => $selected
    );
    array_push($array, $arr);
}

endCode($array, true);