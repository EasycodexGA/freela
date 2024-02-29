<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$id = scapeString($__CONEXAO__, $_GET['id']);
$id = setNum($id);
$id = decrypt($id);

$local  = scapeString($__CONEXAO__, $_GET['local']);
$local  = setString($local);
$local  = decrypt($local);

echo "a-";

if($local == "alunos"){
echo "b-";
    
    deletarAluno($__CONEXAO__, $id);
echo "c-";

}


if($local == "categorias"){
    deletarCategoria($__CONEXAO__, $id);
}


if($local == "eventos"){
    deletarEventos($__CONEXAO__, $id);
}


if($local == "professores"){
    deletarProfessor($__CONEXAO__, $id);
}


if($local == "turmas"){
    deletarTurma($__CONEXAO__, $local, $id);
}


// FUNCTIONS

function deletarAluno($__CONEXAO__, $id){
echo "d-";

    if($__TYPE__ < 3){
        $checkQuery = mysqli_query($__CONEXAO__, "select email from users where typeC='1' and id='$id'") or die("a");
        checkQuery('Usuário não encontrado.', $checkQuery, false);

        $assoc = mysqli_fetch_assoc($checkQuery);
        $email = $assoc["email"];
        echo "e-";

        $checkAluno = mysqli_query($__CONEXAO__, "select id from alunos where turma in (select turma from professores)") or die("b");
        checkQuery('Esse aluno não pertence a você.', $checkAluno, true);
echo "f-";

    }
    echo "g-";
    mysqli_query($__CONEXAO__, "delete users, alunos from users left join alunos on users.email = alunos.email where users.email = '$email'") or die("c");
    endCode("Aluno deletado com sucesso", true);
    echo "h-";

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

function checkQuery($res, $response, $status){
    if($status and $__TYPE__ == 3){
        return;
    }

    if(mysqli_num_rows($response) < 1){
        endCode($res, false);
    }
}