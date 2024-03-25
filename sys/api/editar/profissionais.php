<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);


$id             = scapeString($__CONEXAO__, $json->id);
$cpf            = scapeString($__CONEXAO__, $json->cpf);
$nome           = scapeString($__CONEXAO__, $json->nome);
$email          = scapeString($__CONEXAO__, $json->email);
$nascimento     = scapeString($__CONEXAO__, $json->nascimento);
$titularidade   = scapeString($__CONEXAO__, $json->titularidade);
$active         = scapeString($__CONEXAO__, $json->active);

$id             = setNum($id);
$cpf            = setCpf($cpf);
$nome           = setString($nome);
$email          = setEmail($email);
$nascimento     = setNum($nascimento);
$titularidade   = setNoXss($titularidade);
$active         = setNum($active);

checkMissing(
    array(
        $id,
        $cpf,
        $nome,
        $email,
        $nascimento,
        $titularidade
    )
);

$id = decrypt($id);
$active = decrypt($active);

$check = mysqli_query($__CONEXAO__, "select email from users where id='$id' and typeC='2'");

if(mysqli_num_rows($check) < 1){
    endCode("Usuário não existe", false);
}

$emm = mysqli_fetch_assoc($check);
$emm = $emm["email"];

$checkRepeat = mysqli_query($__CONEXAO__, "select id from users where email='$email' and id!='$id'");

if(mysqli_num_rows($checkRepeat) > 0){
    endCode("Email já está em uso.", false);
}

$checkRepeat = mysqli_query($__CONEXAO__, "select id from users where cpf='$cpf' and id!='$id'");

if(mysqli_num_rows($checkRepeat) > 0){
    endCode(" CPF já está em uso.", false);
}

mysqli_query($__CONEXAO__, "update users set nome='$nome', cpf='$cpf', email='$email', nascimento='$nascimento', titularidade='$titularidade', active='$active' where id='$id'");
mysqli_query($__CONEXAO__, "update professores set email='$email' where email='$emm'");
endCode("Alterado com sucesso", true);