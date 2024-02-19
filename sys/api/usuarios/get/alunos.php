<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$_query_ = mysqli_query($__CONEXAO__, "select * from alunos");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $turmaid    = decrypt($dados["turma"]);
    $emailuser  = $dados["email"];

    $queryAluno = mysqli_query($__CONEXAO__, "select nome, active from users where email='$emailuser'");

    $assocAluno = mysqli_fetch_assoc($queryAluno);
    $nome       = decrypt($assocAluno["nome"]);
    $status     = $assocAluno["active"];

    $queryTurma     = mysqli_query($__CONEXAO__, "select nome, categoria from turmas where id='$turmaid'");
    $assocTurma     = mysqli_fetch_assoc($queryTurma);
    $nomeTurma      = decrypt($assocTurma["nome"]);
    $categoriaTurma = decrypt($assocTurma["categoria"]);
    

    $status     = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from turmas where categoria='$nome'");

    $arr = array(
        "id"        => $dados["id"], 
        "nome"      => $nome, 
        "turma"     => $nomeTurma,
        "status"    => $status,
        "categoria" => $categoriaTurma,
    );

    array_push($array, $arr);
}

endCode($array, true);