<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$cpf        = scapeString($__CONEXAO__, $json->cpf);
$nome       = scapeString($__CONEXAO__, $json->email);
$turma      = scapeString($__CONEXAO__, $json->turma);
$email      = scapeString($__CONEXAO__, $json->email);
$nascimento = scapeString($__CONEXAO__, $json->nascimento);

if(!$cpf or !$nome or !$turma or !$email or !$nascimento){
    endCode("Algum dado está faltando", false);
}

$nome       = setUser($nome);
$email      = setEmail($email);

if(!$email){
    endCode("Email inválido", false);
}

stopUserExist($__CONEXAO__, $getUserByEmail);

$senha = bin2hex(random_bytes(3));

mysqli_query($__CONEXAO__, "insert into users (nome, email, senha, lastModify) values ('$user', '$email', '$senha', '$__TIME__')")  or die("erro insert");

$subject = "Sua senha provisória é $senha";
$message = "
<html>
    <head>
        <title>$subject</title>
        <style>
            body { font-family: Arial, sans-serif; }
        </style>
    </head>
    <body>
        <div style='background-color:#269C72; color:white; text-align:center; padding: 5px; border-radius: 5px'>
            <h2 style='color:white;'>Senha provisório</h2>
        </div>
        <div style='text-align:center; padding: 5px'>
            <p style='color:black;'>Sua senha provisória</p>
            <h1 style='color:black;'>$senha</h1>
            <p style='color:black; font-size: 13px'>Obrigado por contar conosco!</p>
            <p style='color:black; font-size: 12px'>Todos os direitos reservados - Easycodex $__YEAR__</p>
        </div>
    </body>
</html>
";


$sendEmail = mail($email, $subject, $message, implode("\r\n", $__HEADERS__));

endCode("Sucesso", true);