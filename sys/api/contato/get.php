<?php
include '../../conexao.php';

// justLog($__EMAIL__, $__TYPE__, 2);

if($_SESSION["lastcontato"]){
    if($_SESSION["lastcontato"] > time() - 10){
        $rest = 10 - (time() - $_SESSION["lastcontato"]);
        endCode("Aguarde $rest segundos", false);
    }
}

if(!$_SESSION["lastcontato"] or $_SESSION["lastcontato"] < time() - 10){
    $_SESSION["lastcontato"] = time();
}


header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id   = scapeString($__CONEXAO__, $json->telefone);

$id   = setNum($telefone);

checkMissing(
    array(
        $id
    )
);

$check = mysqli_query($__CONEXAO__, "delete from contatos where id='$id'");

endCode("Removido com sucesso!", true);