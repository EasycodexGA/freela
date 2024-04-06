<?php
include '../../conexao.php';

// justLog($__EMAIL__, $__TYPE__, 2);

if($_SESSION["lastcontato"]){
    if($_SESSION["lastcontato"] > time() - 10){
        $rest = 10 - (time() - $_SESSION["lastcontato"]);
        endCode("Aguarde $rest segundos", false);
    }
}

if(!$_SESSION["lastcontato"] or $_SESSION["lastcontato"] < time() - 10){
    $_SESSION["lastcontato"] = time();
}


header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome       = scapeString($__CONEXAO__, $json->nome);
$email      = scapeString($__CONEXAO__, $json->email);
$telefone   = scapeString($__CONEXAO__, $json->telefone);

$nome       = setString($nome);
$email      = setEmail($email);
$telefone   = setNum($telefone);

checkMissing(
    array(
        $nome,
        $email,
        $telefone
    )
);

$check = mysqli_query($__CONEXAO__, "select id from contatos where telefone='$telefone' or email='$email'");

if(mysqli_num_rows($check) > 0){
    endCode("Alguém já utilizou esses dados", false);
} 

mysqli_query($__CONEXAO__, "insert into contatos (nome, email, telefone, created) values ('$nome', '$email', '$telefone', '$__TIME__')");

endCode("Enviado com sucesso!", true);
