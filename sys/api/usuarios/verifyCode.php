<?php
include '../../conexao.php';

cantLog($__EMAIL__);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$code      = scapeString($__CONEXAO__, $json->code);
$newPass   = scapeString($__CONEXAO__, $json->password);
$email   = scapeString($__CONEXAO__, $json->email);

if(!$code or !$newPass or !$email){
    endCode("Algum dado está faltando", false); 
}

$checkEmail = setEmail($email);
$code = encrypt($code);

if(!$checkEmail){
    endCode("Email inválido", false);
}

$tryConnect = mysqli_query($__CONEXAO__, "select * from users where email='$checkEmail'");

if(mysqli_num_rows($tryConnect) < 1){
    endCode("Usuário não encontrado", false);
}

$tryConnect2 = mysqli_query($__CONEXAO__, "select * from users where email='$checkEmail' and verifycode='$code'");
if(mysqli_num_rows($tryConnect2) < 1){
    endCode("Código incorreto", false);
}

$newPass = password_hash($newPass, PASSWORD_DEFAULT);

mysqli_query($__CONEXAO__, "update users set lastModify='$__TIME__', senha='$newPass', codeDate='' where email='$checkEmail'");

$_SESSION['email'] = $checkEmail;
$_SESSION['password'] = $newPass;

endCode("Sucesso!", true);