<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$type = $_GET['type'];

if($type == 'alunos'){
    $typeC = 1;
} else if($type == 'profissionais'){
    $typeC = 2;
} else {
    endCode('Erro.', false);
}

$_query_ = mysqli_query($__CONEXAO__, "select * from listaespera where typeC='$typeC'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $id         = $_dados_['id'];
    $nome       = decrypt($_dados_["nome"]);
    $email      = decrypt($_dados_['email']);
    $nascimento = decrypt($_dados_['nascimento']);
    $titularidade =  decrypt($_dados_['titularidade']);
    
    $arr = array(
        "id"        => $id, 
        "nome"      => $nome, 
        "email"     => $email,
        "data"      => $nascimento,
    );
    if($type == 'profissionais'){
        array_merge($arr, array("titularidade"=>$titularidade));
    }
    array_push($array, $arr);
}

endCode($array, true);