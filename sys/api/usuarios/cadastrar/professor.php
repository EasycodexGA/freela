<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request    = file_get_contents('php://input');
$json       = json_decode($request);

$espera = $json->espera;
$email     = $json->email; 
$insert = $json->insert ? $json->insert : false;

if($email and $espera = true and $insert == true){
    $email = scapeString($__CONEXAO__, $email);
    $email = setNum($email);
    $query = mysqli_query($__CONEXAO__, "select * from listaespera where email='$email'") or die("no email1");
    if(mysqli_num_rows($query) == 0){
        endCode("Usuário na lista de espera não existe", false);
    }
    $fetch = mysqli_fetch_assoc($query);
    
    $cpf            = $fetch['cpf'];
    $nome           = $fetch['nome'];
    $email          = $fetch['email'];
    $nascimento     = $fetch['nascimento'];
    $titularidade   = $fetch['titularidade'];

    mysqli_query($__CONEXAO__, "delete from listaespera where email='$email'") or die("no id2");
} else {
    $cpf            = scapeString($__CONEXAO__, $json->cpf);
    $nome           = scapeString($__CONEXAO__, $json->nome);
    $email          = scapeString($__CONEXAO__, $json->email);
    $nascimento     = scapeString($__CONEXAO__, $json->nascimento);
    $titularidade   = scapeString($__CONEXAO__, $json->titularidade);

    $cpf            = setCpf($cpf);
    $nome           = setString($nome);
    $email          = setEmail($email);
    $nascimento     = setNum($nascimento);
    $titularidade   = setNoXss($titularidade);
}

checkMissing(
    array(
        $cpf, 
        $nome, 
        $email,
        $nascimento,
        $titularidade
    )
);

if(!$email){
    endCode("Email inválido", false);
}

stopUserExist($__CONEXAO__, $email, $cpf);

$query = mysqli_query($__CONEXAO__, "select id from listaespera where email='$email'");
if(mysqli_num_rows($query) > 0){
    endCode("Email já cadastrado na lista de espera", false);
}
$query = mysqli_query($__CONEXAO__, "select id from listaespera where cpf='$cpf'");
if(mysqli_num_rows($query) > 0){
    endCode("CPF já cadastrado na lista de espera", false);
}

if($espera){
    mysqli_query($__CONEXAO__, "insert into listaespera (nome, email, cpf, nascimento, typeC, titularidade, created) values ('$nome', '$email', '$cpf', '$nascimento', '2', '$titularidade', '$__TIME__')")  or die("erro insert");
    endCode("Sucesso, professor cadastrado na lista de espera!");
}

$senha = bin2hex(random_bytes(3));
$senhaH = password_hash($senha, PASSWORD_DEFAULT);

mysqli_query($__CONEXAO__, "insert into users (nome, email, senha, cpf, nascimento, typeC, lastModify, titularidade, active, created) values ('$nome', '$email', '$senhaH', '$cpf', '$nascimento', '2', '$__TIME__', '$titularidade', '$espera', '$__TIME__')")  or die("erro insert");
mysqli_query($__CONEXAO__, "insert into professores (email) values ('$email')")  or die("erro insert");

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
        <div style='background-color:#114494; color:white; text-align:center; padding: 5px; border-radius: 5px'>
            <h2 style='color:white;'>Senha provisória - Professor</h2>
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


$sendEmail = mail(decrypt($email), $subject, $message, implode("\r\n", $__HEADERS__));

endCode("Sucesso, email enviado!", true);