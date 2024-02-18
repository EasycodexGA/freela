<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$email      = scapeString($__CONEXAO__, $json->email);
$nascimento = scapeString($__CONEXAO__, $json->nascimento);

if(!$cpf or !$nome or !$turma or !$email or !$nascimento){
    endCode("Algum dado está faltando", false);
}

$cpf        = setNum($cpf);
$nome       = setString($nome);
$turma      = setString($turma);
$email      = setEmail($email);
$nascimento = setNum($nascimento);