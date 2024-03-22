<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$_query_ = mysqli_query($__CONEXAO__, "select * from recados where fromid='$__ID__'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $id     = $dados["id"];
    $title  = decrypt($dados["title"]);
    $desc   = decrypt($dados["descricao"]);
    $type   = $dados["type"];
    $to     = $dados["toid"];
    $time   = $dados["time"];
    $active = $dados["active"];

    $status = $active == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $id,
        "title"     => $title,
        "desc"      => $desc,
        "type"      => $type,
        "to"        => $to,
        "time"      => $time,
        "status"    => $status,
    );
    array_push($array, $arr);
}

endCode($array, true);