<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$_query_ = mysqli_query($__CONEXAO__, "select nome, active, email, nascimento, id, titularidade from users where typeC='2'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){

    $email          = $_dados_["email"];
    $emailuser      = decrypt($email);
    $nome           = decrypt($_dados_["nome"]);
    $nascimento     = decrypt($_dados_["nascimento"]);
    $titularidade   = decrypt($_dados_["titularidade"]);
    $status         = $_dados_["active"];
    $status         = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"            => $_dados_["id"], 
        "nome"          => $nome, 
        "email"         => $emailuser,
        "data"          => $nascimento,
        "titularidade"  => $titularidade,
        "status"        => $status,
        "_name"         => "profissionais"
    );

    array_push($array, $arr);
}

endCode($array, true);