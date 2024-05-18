<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$id     = scapeString($__CONEXAO__, $_GET['id']);
$id     = setNum($id);
$id     = decrypt($id);
$_query_ = mysqli_query($__CONEXAO__, "select * from rifas where id='$id'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $nome   = decrypt($_dados_["nome"]);


    $status = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $id,
        "nome"      => $nome,
        "desc"      => $desc,
        "premios"   => $premios,
        "qt"        => $qt,
        "valor"     => $valor,
        "selected"  => $selected
    );
    array_push($array, $arr);
}

endCode($array, true);