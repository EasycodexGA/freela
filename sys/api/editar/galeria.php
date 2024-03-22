<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id     = scapeString($__CONEXAO__, $json->id);
$title  = scapeString($__CONEXAO__, $json->title);

$id     = setNum($id);
$title  = setNoXss($nome);

checkMissing(
    array(
        $id,
        $title
    )
);

$id = decrypt($id);

$check = mysqli_query($__CONEXAO__, "select id from grupoimagem where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Grupo não existe", false);
}


mysqli_query($__CONEXAO__, "update grupoimagem set nome='$title' where id='$id'");

endCode("Alterado com sucesso", true);