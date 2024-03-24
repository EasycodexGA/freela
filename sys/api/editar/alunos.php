<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);


$id             = scapeString($__CONEXAO__, $json->id);
$cpf            = scapeString($__CONEXAO__, $json->cpf);
$nome           = scapeString($__CONEXAO__, $json->nome);
$email          = scapeString($__CONEXAO__, $json->email);
$nascimento     = scapeString($__CONEXAO__, $json->nascimento);
$turmas         = $json->turmas;
$active         = scapeString($__CONEXAO__, $json->active);

$id             = setNum($id);
$cpf            = setCpf($cpf);
$nome           = setString($nome);
$email          = setEmail($email);
$nascimento     = setNum($nascimento);
$active         = setNum($active);

checkMissing(
    array(
        $id,
        $cpf,
        $nome,
        $email,
        $nascimento,
    )
);

$id = decrypt($id);
$active = decrypt($active);

$check = mysqli_query($__CONEXAO__, "select id from users where id='$id' and type='1'");

if(mysqli_num_rows($check) < 1){
    endCode("Aluno não existe", false);
}

$emm = mysqli_fetch_assoc($check);
$emm = $emm["email"];

if($__TYPE__ == 2){
    $checkAluno = mysqli_query($__CONEXAO__, "select id from alunos where turma in (select turma from professores where email='$__EMAIL__') and email in (select email from users where typeC='1' and id='$id')") or die("b");
    if(mysqli_num_rows($checkAluno) > 0){
        endCode("Esse aluno não pertence a você", false);
    }
}

$checkRepeat = mysqli_query($__CONEXAO__, "select id from users where email='$email' or cpf='$cpf' and id!='$id'");

if(mysqli_num_rows($checkRepeat) > 0){
    endCode("Email ou CPF já estão em uso por outro usuário", false);
}

mysqli_query($__CONEXAO__, "update users set nome='$nome', cpf='$cpf', email='$email', nascimento='$nascimento', titularidade='$titularidade', active='$active' where id='$id'");
mysqli_query($__CONEXAO__, "update professores set email='$email' where email='$emm'");

endCode("Alterado com sucesso", true);