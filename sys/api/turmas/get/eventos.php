<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos where turma in (select turma from $table where email='$__EMAIL__')");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $data       = $dados["data"];
    $status     = $dados["active"]; 
    $status     = $status == '1' ? "active" : "inactive";
    $turmaId    = $dados["turma"];

    $getCat     = mysqli_query($__CONEXAO__, "select categoria from turma where id='$turma'");
    $categoria  = mysqli_fetch_assoc($getCat)["categoria"];

    $queryT = mysqli_query($__CONEXAO__, "select nome from turmas where id='$turmaId'");

    $turma = mysqli_fetch_assoc($queryT)["nome"];

    $arr = array(
        "id"        => $dados["id"], 
        "nome"      => $nome,
        "turma"     => decrypt($turma),
        "categoria" => decrypt($categoria),
        "data"      => $data,
        "status"    => $status,
        "_name"     => "eventos"
    );
    array_push($array, $arr);
}

endCode($array, true);