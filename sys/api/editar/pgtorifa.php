<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$ref    = scapeString($__CONEXAO__, $json->ref);
$num    = $json->num;
$type   = scapeString($__CONEXAO__, $json->type);

$ref    = setNum($ref);
$type   = setNum($type);

checkMissing(
    array(
        $ref,
        $type
    )
    );

$ref    = decrypt($ref);
$type   = decrypt($type);

foreach($num as &$n){
    $n = setNum($n);
    checkMissing(array($n));
    $n = decrypt($n);
    
    $getNum = mysqli_query($__CONEXAO__, "select id from numerorifa where num='$n' and ref='$ref'");
    if(mysqli_num_rows($getEvento) == 0){
        endCode("Não existe o número $n nesta rifa.", false);
    }
    if($n > $qt or $n < 1){
        endCode("Número $n inexistente na rifa.", false);
    }
}

foreach($num as $n){
    if($type == 0){
        mysqli_query($__CONEXAO__, "delete from numerorifa where ref='$ref' and numero='$n'");
    } else {
        mysqli_query($__CONEXAO__, "update numerorifa set status='paid' where ref='$ref' and numero='$n'");
    }
}


endCode("Sala criada com sucesso", true);