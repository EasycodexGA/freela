<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$aluno  = scapeString($__CONEXAO__, $_GET['id']);
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

    while($dados2 = mysqli_fetch_array($query2)){
        $turmaId    = decrypt($dados2['turma']);
        $query3     = mysqli_query($__CONEXAO__, "select * from turmas where id='$turmaId'");
        $turma      = mysqli_fetch_assoc($query3)['nome'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId));
    }

    $query3 = mysqli_query($__CONEXAO__, "select * from chamada where aluno='$aluno'");

    $presencaArr = array("v"=>0, "f"=>0);
    
    while($dados3 = mysqli_fetch_array($query3)){
        $presenca = $dados3["presenca"];
        if($presenca == 0){
            $presencaArr=>f = $presencaArr=>f + 1;
        } else {
            $presencaArr=>v = $presencaArr=>v + 1;
        }
    }
    
    $query  = mysqli_query($__CONEXAO__, "select * from eventos where nome='$nome'");

    $arr = array(
        "id"            => $decAluno,
        "nome"          => $nome, 
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $arrTurmas,
        "presenca"      => $presencaArr,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);