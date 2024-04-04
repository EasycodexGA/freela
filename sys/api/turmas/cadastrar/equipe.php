<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nome   = scapeString($__CONEXAO__, $json->nome);
$nome   = setNoXss($nome);

checkMissing(
    array(
        $nome
    )
);

$getEquipe = mysqli_query($__CONEXAO__, "select id from equipes where nome='$nome'");

if(mysqli_num_rows($getEquipe) > 0){
    endCode("Já existe uma equipe com esses dados.", false);
}

mysqli_query($__CONEXAO__, "insert into equipes (nome, created) values ('$nome', '$__TIME__')");

endCode("Equipe criada com sucesso", true);