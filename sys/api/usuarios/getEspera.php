<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$type = $_GET['type'];

if($type == 'alunos'){
    $typeC = 1;
} else if($type == 'profissionais'){
    $typeC = 2;
} else {
    endCode('Erro.', false);
}

$_query_ = mysqli_query($__CONEXAO__, "select * from listaespera");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $id         = $_dados_['id'];
    $nome       = decrypt($_dados_["nome"]);
    $email      = decrpyt($_dados_['email']);
    $nascimento = decrpy($_dados_['nascimento']);
    
    $arr = array(
        "id"        => $id, 
        "nome"      => $nome, 
        "email"     => $emailuser,
        "data"      => $nascimento,
    );
    array_push($array, $arr);
}

endCode($array, true);