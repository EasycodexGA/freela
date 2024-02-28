<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome           = scapeString($__CONEXAO__, $json->nome);
$horario        = scapeString($__CONEXAO__, $json->horario);
$categoria      = scapeString($__CONEXAO__, $json->categoria);
$profissional   = scapeString($__CONEXAO__, $json->profissional);

$nome           = setNoXss($nome);
$horario        = setNum($horario);
$categoria      = setNoXss($categoria);
$profissional   = setNum($profissional);

checkMissing(
    array(
        $nome,
        $horario,
        $categoria,
        $profissional
    )
);

$horarioDec = decrypt($horario);

if($horarioDec > 86340000 or $horarioDec < 0){
    endCode("Horário inválido.", false);
}

$profissionalDec = decrypt($profissional);

$getProf = mysqli_query($__CONEXAO__, "select email from users where id='$profissionalDec' and typeC='2'");

if(mysqli_num_rows($getProf) < 1){
    endCode("Responsável inválido.", false);
}

$respEmail  = mysqli_fetch_assoc($getProf)["email"];

$getCat = mysqli_query($__CONEXAO__, "select id from categorias where nome='$categoria'");

if(mysqli_num_rows($getCat) < 1){
    endCode("Categoria inválida.", false);
}

$getTurma = mysqli_query($__CONEXAO__, "select id from turmas where nome='$nome' and categoria='$categoria'");

if(mysqli_num_rows($getTurma) > 0){
    endCode("Já existe uma turma com esses dados.", false);
}

mysqli_query($__CONEXAO__, "insert into turmas (nome, categoria, horario, data) values ('$nome', '$categoria', '$horario','$__TIME__')");
$idTurma = mysqli_insert_id($__CONEXAO__);
$idTurma = encrypt($idTurma);

mysqli_query($__CONEXAO__, "insert into professores (email, turma) values ('$respEmail', '$idTurma')");

endCode("Sala criada com sucesso", true);