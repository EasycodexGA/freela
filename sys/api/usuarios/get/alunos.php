<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$_query_ = mysqli_query($__CONEXAO__, "select nome, active, email, nascimento, id from users where typeC='0'");

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
    );

    array_push($array, $arr);
}

endCode($array, true);