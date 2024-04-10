<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id         = scapeString($__CONEXAO__, $json->id);
$nome       = scapeString($__CONEXAO__, $json->nome);
$data       = scapeString($__CONEXAO__, $json->data);
$turmas     = $json->turmas;
$equipes    = $json->equipes;
$descricao  = scapeString($__CONEXAO__, $json->descrição);
$active     = scapeString($__CONEXAO__, $json->active);

$id         = setNum($id);
$nome       = setNoXss($nome);
$data       = setNum($data);
$descricao  = setNoXss($descricao);
$active     = setNum($active);


checkMissing(
    array(
        $id,
        $nome,
        $data,
        $descricao
    )
);

$id     = decrypt($id);
$data   = decrypt($data);
$active = decrypt($active);

$check = mysqli_query($__CONEXAO__, "select id from eventos where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Evento não existe", false);
}

if($__TYPE__ == 2){
    $checkEvt = mysqli_num_rows($__CONEXAO__, "select id from eventos where turma in (select turma from professores where email='$__EMAIL__') and id='$id'");
    if(mysqli_num_rows($checkEvt) > 0){
        endCode("Esse evento não pertence a sua turma", false);
    }
}

$turmasArray = array();

for($i = 0; $i < count($turmas); $i++){
    $check = $turmas[$i]->checked == 1 ? true : false;
    $idTurma = $turmas[$i]->id;
    if($check){
        array_push($turmasArray, $idTurma);
    }
}

$equipesArray = array();

for($i = 0; $i < count($equipes); $i++){
    $check = $equipes[$i]->checked == 1 ? true : false;
    $idEquipe = $equipes[$i]->id;
    if($check){
        array_push($equipesArray, $idEquipe);
    }
}

$turmasArray = implode(',', $turmasArray);

$equipesArray = implode(',', $equipesArray);

mysqli_query($__CONEXAO__, "update eventos set nome='$nome', data='$data', descricao='$descricao', active='$active', turmas=',$turmasArray', equipes=',$equipesArray' where id='$id'") or die('sahaej');

endCode("Alterado com sucesso", true);