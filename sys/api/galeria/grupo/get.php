<?php
include '../../../conexao.php';

header('Content-Type: application/json; charset=utf-8');

$getAll = mysqli_query($__CONEXAO__, "select nome from grupoimagem");

$nomes = array();

while($dados = mysqli_fetch_array($getAll)){
    $nomeGp = decrypt($dados["nome"]);

    array_push($nomes, $nomeGp);
}

endCode($nomes, true);