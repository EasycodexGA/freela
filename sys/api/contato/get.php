<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);


$query = mysqli_query($__CONEXAO__, "select * from contatos by id desc");

$arrData = array();

while($dados = mysqli_fetch_array($query)){
    $id         = $dados["id"];
    $nome       = decrypt($dados["nome"]);
    $email      = decrypt($dados["email"]);
    $telefone   = decrypt($dados["telefone"]);
    $desc   = decrypt($dados["descr"]);
    
    array_push($arrData, array(
        "id" => $id,
        "nome" => $nome,
        "desc" => $desc,
        "email" => $email,
        "telefone" => $telefone
    ));
}

endCode($arrData, true);