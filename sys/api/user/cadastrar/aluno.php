<?php
include '../../conexao.php';

cantLog($__EMAIL__);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$cpf        = scapeString($json->cpf);
$nome       = scapeString($json->email);
$turma      = scapeString($json->turma);
$email      = scapeString($json->email);
$nascimento = scapeString($json->nascimento);

if(!$user or !$email or !$password or ){
    endCode("Algum dado está faltando", false);
}
