<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);


$horario    = scapeString($__CONEXAO__, $json->horario);
$id         = scapeString($__CONEXAO__, $json->id);
$nome       = scapeString($__CONEXAO__, $json->nome);
$categoria  = scapeString($__CONEXAO__, $json->categoria);
$aulas      = $json->aulas;
$active     = scapeString($__CONEXAO__, $json->active);

$id         = setNum($id);
$nome       = setNoXss($nome);
$horario    = setNum($horario);
$categoria  = setNoXss($categoria);
$active     = setNum($active);

checkMissing(
    array(
        $id,
        $nome,
        $horario
    )
);


$id  = decrypt($id);
$categoria  = decrypt($categoria);
$horarioDec = decrypt($horario);
$active = decrypt($active);


if($__TYPE__ == 2){
    $checkTurma= mysqli_query($__CONEXAO__, "select id from turmas where id in (select turma from professores where email='$__EMAIL__')") or die("b");
    if(mysqli_num_rows($checkTurma) > 0){
        endCode("Essa turma não lhe pertence", false);
    }
}


$checkExist = mysqli_query($__CONEXAO__, "select id from turmas where nome='$nome' and categoria='$categoria' and id!='$id'") or die("nao 3");

if(mysqli_num_rows($checkExist) > 0){
    endCode("Já existe uma turma com esses dados.", false);
}


for($i = 0; $i < count($aulas); $i++){
    // endCode(var_dump($aulas), false);
    $idAula = $aulas[$i]->id;
    $chamadaAula = $aulas[$i]->chamada;
    for($j = 0; $j < count($chamadaAula); $j++){
        $checkAula = $chamadaAula[$j]->checked;
        $check_query = mysqli_query($__CONEXAO__, "select id from chamada where id='$idAula'") or endCode("asd 1", false);
        if(mysqli_num_rows($check_query) > 0){
            $checkChamada = mysqli_query($__CONEXAO__, "select id from chamada where id='$idAula' and presenca='$checkAula'")  or endCode("asd 2", false);
            if(mysqli_num_rows($checkChamada) == 0){
                mysqli_query($__CONEXAO__, "update chamada set presenca='$checkAula' where id='$idAula'")  or endCode("asd 3", false);
            }
        }
    }
}


mysqli_query($__CONEXAO__, "update turmas set nome='$nome', horario='$horario', active='$active' where id='$id'");

endCode("Alterado com sucesso", true);