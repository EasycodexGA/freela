<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id     = scapeString($__CONEXAO__, $json->id);
$title  = scapeString($__CONEXAO__, $json->title);
$desc   = scapeString($__CONEXAO__, $json->desc);
$time   = scapeString($__CONEXAO__, $json->data);
$active = scapeString($__CONEXAO__, $json->active);

$id     = setNum($id);
$title  = setNoXss($title);
$desc   = setNoXss($desc);
$time   = setNum($time);
$active = setNum($active);

checkMissing(
    array(
        $id,
        $title,
        $desc,
        $time,
    )
);

$id     = decrypt($id);
$time   = decrypt($time);

// coloquei o active para ser automativo e ficar inativo depois de passar a data 
// demais informações que não estão aqui, não precisam ser editadas 

mysqli_query($__CONEXAO__, "update recados set title='$title', descricao='$desc', time='$time', active='$active' where id='$id'");

endCode("Alterado com sucesso", true);