<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request    = file_get_contents('php://input');
$json       = json_decode($request);

$espera = $json->espera;
$email     = $json->email; 

if($email){
    $email = scapeString($__CONEXAO__, $email);
    $email = setEmail($email);
    $query = mysqli_query($__CONEXAO__, "select * from listaespera where email='$email'");
    if(mysqli_num_rows($query) == 0){
        endCode("Usuário na lista de espera não existe", false);
    }
    $fetch = mysqli_fetch_assoc($query);
    
    $cpf        = $fetch['cpf'];
    $nome       = $fetch['nome'];
    $type       = $fetch['typeC'];
    $email      = $fetch['email'];
    $nascimento = $fetch['nascimento'];
    // fazer aqui para ser aprovado 
    // mandar email com senha 
    // colocar no users e em alunos
    mysqli_query($__CONEXAO__, "delete from listaespera where email='$email'");
    endCode("Aluno aprovado", true);
} else {
    $cpf        = scapeString($__CONEXAO__, $json->cpf);
    $nome       = scapeString($__CONEXAO__, $json->nome);
    $email      = scapeString($__CONEXAO__, $json->email);
    $nascimento = scapeString($__CONEXAO__, $json->nascimento);

    $cpf        = setCpf($cpf);
    $nome       = setString($nome);
    $email      = setEmail($email);
    $nascimento = setNum($nascimento);
}

checkMissing(
    array(
        $cpf, 
        $nome, 
        $email,
        $nascimento,
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
    mysqli_query($__CONEXAO__, "insert into listaespera (nome, email, cpf, nascimento, created) values ('$nome', '$email', '$cpf', '$nascimento', '$__TIME__')")  or die("erro insert");
    endCode("Sucesso, aluno cadastrado na lista de espera!", true);
}

$turma      = scapeString($__CONEXAO__, $json->turma);
$turma      = setNum($turma);
checkMissing(array($turma));

$tid = decrypt($turma);

$queryRoom = mysqli_query($__CONEXAO__, "select id from turmas where id='$tid'");

if(mysqli_num_rows($queryRoom) < 1){
    endCode("Turma inexistente", false);
}

$senha = bin2hex(random_bytes(3));
$senhaH = password_hash($senha, PASSWORD_DEFAULT);

mysqli_query($__CONEXAO__, "insert into users (nome, email, senha, cpf, nascimento, lastModify, active, created) values ('$nome', '$email', '$senhaH', '$cpf', '$nascimento', '$__TIME__', '1', '$__TIME__')")  or die("erro insert");
mysqli_query($__CONEXAO__, "insert into alunos (email, turma) values ('$email', '$tid')")  or die("erro insert");

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
            <h2 style='color:white;'>Senha provisória - Aluno</h2>
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

$dec = decrypt($email);

endCode("Sucesso $dec", true);