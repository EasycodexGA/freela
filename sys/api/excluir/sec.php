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
    deletarCategoria($__CONEXAO__, $__TYPE__, $id);
}


if($local == "eventos"){
    deletarEventos($__CONEXAO__, $__TYPE__, $id);
}


if($local == "professores"){
    deletarProfessor($__CONEXAO__, $__TYPE__, $id);
}


if($local == "turmas"){
    deletarTurma($__CONEXAO__, $__TYPE__, $id);
}


// FUNCTIONS

function deletarAluno($__CONEXAO__, $__TYPE__, $__EMAIL__, $id){

    $checkQuery = mysqli_query($__CONEXAO__, "select email from users where typeC='1' and id='$id'") or die("a");
    checkQuery($__TYPE__, 'Usuário não encontrado.', $checkQuery, false);

    $assoc = mysqli_fetch_assoc($checkQuery);
    $email = $assoc["email"];

    $checkAluno = mysqli_query($__CONEXAO__, "select id from alunos where turma in (select turma from professores where email='$__EMAIL__') and email in (select email from users where typeC='1' and id='$id' )") or die("b");
    echo $__EMAIL__;
    checkQuery($__TYPE__, 'Esse aluno não pertence a você.', $checkAluno, true);

    mysqli_query($__CONEXAO__, "delete from users where email='$email'") or die("c");
    mysqli_query($__CONEXAO__, "delete from alunos where email='$email'") or die("c");
    endCode("Aluno deletado com sucesso $email", true);

    return;
    exit;
}

function deletarCategoria($__CONEXAO__, $local, $id){
 
    return;
    exit;
}

function deletarEventos($__CONEXAO__, $local, $id){

    return;
    exit;
}

function deletarProfessor($__CONEXAO__, $local, $id){

    return;
    exit;
}

function deletarTurma($__CONEXAO__, $local, $id){

    return;
    exit;
}

function checkQuery($__TYPE__, $res, $response, $status){
    echo $status . " " . $__TYPE__;
    if($status and $__TYPE__ == 3){
        echo "asd";
        return;
    }

    if(mysqli_num_rows($response) < 1){
        endCode($res, false);
    }
}