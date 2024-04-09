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

$takeData = mysqli_query($__CONEXAO__, "select nome, data, descricao from eventos where id='$id'");
$nomeA = mysqli_fetch_assoc($takeData)['nome'];
$dataA = mysqli_fetch_assoc($takeData)['data'];
$descA = mysqli_fetch_assoc($takeData)['descricao'];

for($i = 0; $i < count($turmas); $i++){
    $check = $turmas[$i]->checked;
    $idTurma = $turmas[$i]->id;
    $check = $check == 1 ? true : false;
    $check_query = mysqli_query($__CONEXAO__, "select id from eventos where turma='$idTurma' and where nome='$nomeA' and data='$dataA'");
    if($check){
        if(mysqli_num_rows($check_query) == 0){
            mysqli_query($__CONEXAO__, "insert into eventos (nome, data, descricao, turma) values ('$nomeA','$dataA','$descA','$idTurma')") or die('ccc');
        }
    } else {
        if(mysqli_num_rows($check_query) > 0){
            mysqli_query($__CONEXAO__, "delete from eventos where where nome='$nomeA' and data='$dataA' and turma='$idTurma'");
        }
    }
}

for($i = 0; $i < count($equipes); $i++){
    $check = $equipes[$i]->checked;
    $idEquipe = $equipes[$i]->id;
    $check_query = mysqli_query($__CONEXAO__, "select id from eventos where equipe='$idEquipe' and where nome='$nomeA' and data='$dataA'");
    if($check){
        if(mysqli_num_rows($check_query) == 0){
            mysqli_query($__CONEXAO__, "insert into eventos (nome, descricao, data, equipe) values ('$nomeA', '$descA', '$dataA','$idEquipe')");
        }
    } else {
        if(mysqli_num_rows($check_query) > 0){
            mysqli_query($__CONEXAO__, "delete from eventos where where nome='$nomeA' and data='$dataA' and equipe='$idEquipe'");
        }
    }
}

mysqli_query($__CONEXAO__, "update eventos set nome='$nome', data='$data', descricao='$descricao', active='$active' where id='$id'");

endCode("Alterado com sucesso", true);