<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$title  = scapeString($__CONEXAO__, $json->title);
$desc   = scapeString($__CONEXAO__, $json->desc);
$time   = scapeString($__CONEXAO__, $json->time);
$type   = scapeString($__CONEXAO__, $json->type);
$to     = scapeString($__CONEXAO__, $json->to);


if($type == 3){
    $to = "geral";
    $to = setString($to);
} else {
    $to = setNum($to);
}

$title  = setString($title);
$desc   = setNoXss($desc);
$time   = setNum($time);
$type   = setNum($type);




checkMissing(
    array(
        $title,
        $desc,
        $time,
        $type,
        $to,
    )
);



$time = decrypt($time);
$type = decrypt($type);
$to = decrypt($to);

if($type == 3){
    $to = 0;
}

$check = mysqli_query($__CONEXAO__, "select id from recados where title='$title' and type='$type' and to='$to'");

if(mysqli_num_rows($check) > 0){
    endCode("Mensagem igual", false);
}

mysqli_query($__CONEXAO__, "insert into recados (type, fromid, toid, title, descricao, time) values ('$type', '$__ID__', '$to', '$title', '$desc', '$time')");

endCode("Enviado", true);