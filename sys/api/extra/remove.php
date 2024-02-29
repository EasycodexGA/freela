<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$id = scapeString($__CONEXAO__, $_GET['id']);
$id = setNum($id);
$id = decrypt($id);

$local  = scapeString($__CONEXAO__, $_GET['local']);
$local  = setString($local);
$local  = decrypt($local);


if($local == "alunos"){
    deletarAluno($__CONEXAO__, $__TYPE__, $__EMAIL__, $id);
}


if($local == "categorias"){
    deletarCategoria($__CONEXAO__, $__TYPE__, $__EMAIL__, $id);
}


if($local == "eventos"){
    deletarEventos($__CONEXAO__, $__TYPE__, $__EMAIL__, $id);
}


if($local == "profissionais"){
    deletarProfessor($__CONEXAO__, $__TYPE__, $__EMAIL__, $id);
}


if($local == "turmas"){
    deletarTurma($__CONEXAO__, $__TYPE__, $__EMAIL__, $id);
}


// FUNCTIONS

function deletarAluno($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){

    $checkQuery = mysqli_query($__CONEXAO__, "select email from users where typeC='1' and id='$id'") or die("a");
    checkQuery($__TYPE__, 'Usuário não encontrado.', $checkQuery, false);

    $assoc = mysqli_fetch_assoc($checkQuery);
    $email = $assoc["email"];

    $checkAluno = mysqli_query($__CONEXAO__, "select id from alunos where turma in (select turma from professores where email='$__EMAIL__') and email in (select email from users where typeC='1' and id='$id')") or die("b");
    checkQuery($__TYPE__, 'Esse aluno não pertence a você.', $checkAluno, true);

    mysqli_query($__CONEXAO__, "delete from users where email='$email'") or die("c");
    mysqli_query($__CONEXAO__, "delete from alunos where email='$email'") or die("c");
    endCode("Aluno deletado com sucesso", true);

    return;
    exit;
}

function deletarCategoria($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){
    justLog($__EMAIL__, $__TYPE__, 3);

    $checkQuery = mysqli_query($__CONEXAO__, "select id from categorias where id='$id'") or die("a");
    checkQuery($__TYPE__, 'Categoria não encontrada.', $checkQuery, false);

    $preDelete = mysqli_query($__CONEXAO__, "select id from turmas where categoria='$id'");
    checkQueryM('Ainda existem turmas com essa categoria.', $preDelete);
    
    mysqli_query($__CONEXAO__, "delete from categorias where id='$id'") or die("c");
    endCode("Categoria deletada com sucesso", true);
    return;
    exit;
}

function deletarEventos($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){
    $checkQuery = mysqli_query($__CONEXAO__, "select id from eventos where id='$id'") or die("a");
    checkQuery($__TYPE__, 'Evento não encontrado.', $checkQuery, false);

    $checkEvt = mysqli_num_rows($__CONEXAO__, "select id from eventos where turma in (select turma from professores where email='$__EMAIL__') and id='$id'");
    checkQuery($__TYPE__, 'Evento não é da sua turma.', $checkQuery, true);

    mysqli_query($__CONEXAO__, "delete from eventos where id='$id'") or die("c");
    endCode("Evento deletado com sucesso", true);
    return;
    exit;
}

function deletarProfessor($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){
    justLog($__EMAIL__, $__TYPE__, 3);

    $checkQuery = mysqli_query($__CONEXAO__, "select email from users where typeC='2' and id='$id'") or die("a");
    checkQuery($__TYPE__, 'Profissional não encontrado.', $checkQuery, false);

    $assoc = mysqli_fetch_assoc($checkQuery);
    $email = $assoc["email"];

    mysqli_query($__CONEXAO__, "delete from users where email='$email'") or die("c");
    mysqli_query($__CONEXAO__, "delete from professores where email='$email'") or die("c");
    endCode("Profissional deletado com sucesso", true);
    return;
    exit;
}

function deletarTurma($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){
    justLog($__EMAIL__, $__TYPE__, 3);

    $checkQuery = mysqli_query($__CONEXAO__, "select id from turmas where id='$id'") or die("a");
    checkQuery($__TYPE__, 'Turma não encontrada.', $checkQuery, false);

    mysqli_query($__CONEXAO__, "delete from turmas where id='$id'") or die("c");
    endCode("Turma deletada com sucesso", true);
    return;
    exit;
}

function checkQuery($__TYPE__, $res, $response, $status){
    if($status and $__TYPE__ == 3){
        return;
    }

    if(mysqli_num_rows($response) < 1){
        endCode($res, false);
    }
}

function checkQueryM($res, $response){
    if(mysqli_num_rows($response) > 0){
        endCode($res, false);
    }
}