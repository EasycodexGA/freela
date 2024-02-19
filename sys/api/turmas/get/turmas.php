<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$_query_ = mysqli_query($__CONEXAO__, "select * from turmas");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome = decrypt($dados["nome"]);
    $categoria = decrypt($dados["categoria"]);
    
    $arr = array("id"=>$dados["id"], "nome"=>$nome, "categoria"=>$categoria);
    array_push($array, $arr);
}

endCode($array, true);