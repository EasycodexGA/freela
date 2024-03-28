<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$__TIME__ = $__TIME__ - 8600;

$escrita = "";
if($__TYPE__ == 2){
    $escrita = "where fromid='$__ID__'";
}

$_query_ = mysqli_query($__CONEXAO__, "select * from recados $escrita order by time desc");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $id     = $dados["id"];
    $title  = decrypt($dados["title"]);
    $desc   = decrypt($dados["descricao"]);
    $type   = $dados["type"];
    $to     = $dados["toid"];
    $time   = $dados["time"];
    $active = $dados["active"];

    if($time < $__TIME__){
        // endCode("$time < $__TIME__", false);
        mysqli_query($__CONEXAO__, "update recados set active='0' where id='$id'");
        $active = "0";
    }

    if($type == "1"){
        $getTo = mysqli_query($__CONEXAO__, "select nome from users where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
    }

    if($type == "2"){
        $getTo = mysqli_query($__CONEXAO__, "select nome from turmas where id='$to'");
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
        "data"      => $time,
        "status"    => $status,
    );
    array_push($array, $arr);
}

endCode($array, true);