<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$aluno  = scapeString($__CONEXAO__, $json->aluno);
$aluno = setNum($aluno);
$decAluno = decrypt($aluno);

$_query_ = mysqli_query($__CONEXAO__, "select * from users where id='$decAluno'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $email = decrypt($dados["nome"]);
    $query  = mysqli_query($__CONEXAO__, "select * from users where email='$email'");
    
    $nome       = decrypt($query["nome"]);
    $cpf        = decrypt($query["cpf"]);
    $nascimento = decrypt($query["nascimento"]);
    $status     = $query["active"];

    $status = $status == '1' ? "active" : "inactive";

    $query2 = mysqli_query($__CONEXAO__, "select * from alunos where email='$email'");

    $arrTurmas = array();

    while($dados2 = mysqli_fetch_array($query)){
        $turmaId    = decrypt($dados2['turma']);
        $query3     = mysqli_query($__CONEXAO__, "select * from turmas where id='$turmaId'");
        $turma      = mysqli_fetch_assoc($query3)['nome'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId));
    }
    
    $query  = mysqli_query($__CONEXAO__, "select * from eventos where nome='$nome'");

    $arr = array(
        "id"            => $decAluno,
        "nome"          => $nome, 
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $arrTurmas,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);