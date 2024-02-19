<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$_query_ = mysqli_query($__CONEXAO__, "select * from professores");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $emailuser      = $dados["email"];
    $titularidade   = decrypt($dados["titularidade"]);

    $queryAluno = mysqli_query($__CONEXAO__, "select nome, active from users where email='$emailuser'");

    $assocAluno = mysqli_fetch_assoc($queryAluno);
    $nome       = decrypt($assocAluno["nome"]);
    $status     = $assocAluno["active"];

    $status     = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from turmas where categoria='$nome'");

    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "turmas"        => 0,
        "status"        => $status,
        "titularidade"  => $titularidade,
    );

    array_push($array, $arr);
}

endCode($array, true);