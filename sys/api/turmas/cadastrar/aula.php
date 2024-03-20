<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turma      = scapeString($__CONEXAO__, $json->turma);
$descricao  = scapeString($__CONEXAO__, $json->descricao);
$data       = scapeString($__CONEXAO__, $json->data);
$presenca   = $json->presenca;

$turma      = setNum($turma);
$descricao  = setNoXss($descricao);
$data       = setNum($data);

checkMissing(
    array(
        $turma,
        $data,
        $descricao
    )
);

$turma = decrypt($turma);

$getTurma = mysqli_query($__CONEXAO__, "select id from turmas where id='$turma'");

if(mysqli_num_rows($getTurma) < 1){
    endCode("Turma inválida.", false);
}

$data = decrypt($data);

if($data > time() + (86400 * 7) or $data < time() - (86400 * 28)){
    endCode("Data superior a 7 dias ou inferior a 28.", false);
}

$getDatas = mysqli_query($__CONEXAO__, "select id from aulas where turma='$turma' and data='$data'");

if(mysqli_num_rows($getDatas) > 0){
    endCode("Já existe uma aula para este dia.", false);
}

mysqli_query($__CONEXAO__, "insert into aulas (turma, descricao, data) values ('$turma', '$descricao', '$data')");
$aulaId = mysqli_insert_id($__CONEXAO__);

endCode($presenca, false);

for($i = 0; $i < count($presenca); $i++){
    $idAluno = $presenca[$i][$id];
    $bool = $presenca[$i][$presenca];
    mysqli_query($__CONEXAO__, "insert into chamada (aula, aluno, presenca) values ('$aulaId','$idAluno','$bool')");
}

endCode("Aula criada com sucesso", true);