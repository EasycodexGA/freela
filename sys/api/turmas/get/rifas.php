<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $premio     = $dados['premios'];
    $img        = $premio[0]->img;
    $valor      = decrypt($dados['valor']);

    $arr = array(
        "id"        => $dados["id"], 
        "nome"      => $nome,
        "img"       => $img,
        "valor"     => $valor
    );
    array_push($array, $arr);
}

endCode($array, true);