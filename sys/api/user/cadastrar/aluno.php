<?php
include '../../conexao.php';

cantLog($__EMAIL__);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$cpf        = scapeString($json->cpf;
$nome       = $json->email;
$turma      = $json->turma;
$email      = $json->email;
$nascimento = $json->nascimento;
