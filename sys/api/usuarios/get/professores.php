<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$_query_ = mysqli_query($__CONEXAO__, "select nome, active, email, nascimento, id from users where typeC='2'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){

    $email = $dados["email"];
    $emailuser  = decrypt($email);
    $nome       = decrypt($dados["nome"]);
    $nascimento = decrypt($dados["nascimento"]);
    $titularidade = decrypt($dados["titularidade"]);
    $status     = $dados["active"];

    $q2 = mysqli_query($__CONEXAO__, "select titularidade from professores where email='$email'");

    $titularidade = mysqli_fetch_assoc($q2)['titularidade'];
    $titularidade = decrypt($titularidade);
    
    $status     = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "email"         => $emailuser,
        "data"          => $nascimento,
        "status"        => $status,
        "titularidade"  => $titularidade,
        "_name"         => "profissionais"
    );

    array_push($array, $arr);
}

endCode($array, true);