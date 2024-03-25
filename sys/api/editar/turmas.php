<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id             = scapeString($__CONEXAO__, $json->id);
$nome           = scapeString($__CONEXAO__, $json->nome);
$horario        = scapeString($__CONEXAO__, $json->horario);
$categoria      = scapeString($__CONEXAO__, $json->categoria);
$active         = scapeString($__CONEXAO__, $json->active);

$categoria      = intval($categoria);
$id             = setNum($id);
$nome           = setNoXss($nome);
$horario        = setNum($horario);
$categoria      = setNum($categoria);
$active         = setNum($active);


checkMissing(
    array(
        $id,
        $nome,
        $horario,
        $categoria,
    )
);

$categoria  = decrypt($categoria);
$horarioDec = decrypt($horario);
$active = decrypt($active);

if($__TYPE__ == 2){
    $checkTurma= mysqli_query($__CONEXAO__, "select id from turmas where id in (select turma from professores where email='$__EMAIL__') and id='$id')") or die("b");
    if(mysqli_num_rows($checkTurma) > 0){
        endCode("Essa turma não lhe pertence", false);
    }
}


$checkExist = mysqli_query($__CONEXAO__, "select id from turmas where nome='$nome' and categoria='$categoria'");

if(mysqli_num_rows($checkExist) > 0){
    endCode("Já existe uma turma com esses dados.", false);
}

mysqli_query($__CONEXAO__, "update turmas set nome='$nome', categoria='$categoria', horario='$horario', active='$active' where id='$id'");

endCode("Alterado com sucesso", true);