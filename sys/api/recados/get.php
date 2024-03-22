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

    if($type == "1"){
        $getTo = mysqli_query($__CONEXAO__, "select nome users where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
    }

    if($type == "2"){
        $getTo = mysqli_query($__CONEXAO__, "select nome turmas where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
    }

    if($type == "3"){
        $to = "Todos";
    }
    

    $status = $active == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $id,
        "title"     => $title,
        "to"        => $to,
        "time"      => $time,
        "status"    => $status,
    );
    array_push($array, $arr);
}

endCode($array, true);