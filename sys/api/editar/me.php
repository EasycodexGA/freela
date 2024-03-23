<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$pass   = scapeString($__CONEXAO__, $json->pass);
$email  = scapeString($__CONEXAO__, $json->email);

if((!$pass and !$email) or (encrypt($email) == $__EMAIL__) or ($pass == " " or $pass == "") or ($email == "" or $email == " ")){
    endCode("Nenhum dado recebido.", false);
}

$dados = "";

if($pass){
    $pass   = encrypt($pass);
    $dados  .= "(senha)";
    $_SESSION["password"] = $pass;
    mysqli_query($__CONEXAO__, "update users set senha='$pass' where id='$__ID__'");
}

if($email){
    $email  = setEmail($email);
    if($email != $__EMAIL__){
        $dados  .= "(email)";
        $_SESSION["email"] = $email;
        mysqli_query($__CONEXAO__, "update users set email='$email' where id='$__ID__'");
    }
}

endCode("Dados atualizados: $dados", true);