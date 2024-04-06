<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id     = scapeString($__CONEXAO__, $json->id);
$title  = scapeString($__CONEXAO__, $json->nome);
$active = scapeString($__CONEXAO__, $json->active);

$id     = setNum($id);
$title  = setNoXss($title);
$active = setNum($active);

checkMissing(
    array(
        $id,
        $title
    )
);

$id     = decrypt($id);
$active = decrypt($active);

$check = mysqli_query($__CONEXAO__, "select id from equipes where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Equipe não existe", false);
}

mysqli_query($__CONEXAO__, "update equipes set nome='$title', active='$active' where id='$id'");

endCode("Alterado com sucesso", true);