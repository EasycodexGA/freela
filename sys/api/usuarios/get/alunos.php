<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select nome, active, email, nascimento, id from users where typeC='1'");
} else {
    $_query_ = mysqli_query($__CONEXAO__, "select nome, active, email, nascimento, id from users where typeC='1' and email in (select email from alunos where turma in (select turma from professores where email='$__EMAIL__'))");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){

    $emailuser  = decrypt($dados["email"]);
    $nome       = decrypt($dados["nome"]);
    $nascimento = decrypt($dados["nascimento"]);
    $status     = $dados["active"];
    
    $status     = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "email"         => $emailuser,
        "data"          => $nascimento,
        "status"        => $status,
        "_name"         => "alunos"
    );

    array_push($array, $arr);
}

endCode($array, true);