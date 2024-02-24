<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 0);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$evento  = scapeString($__CONEXAO__, $json->evento);
$evento = setNum($evento);
$decEvento = decrypt($evento);

$_query_ = mysqli_query($__CONEXAO__, "select * from eventos where id='$decEvento'");
$turmaEvento = mysqli_fetch_assoc($_query_)['turma'];
$turmaEvento = decrypt($turmaEvento);

if($__TYPE__ < 2) {
    checkTurma($turmaEvento, "Você não está participando deste evento.", "eventos where id='$decEvento'");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $turma      = decrypt($dados["turma"]);
    $categoria  = decrypt($dados["categoria"]);
    $idC        = encrypt($dados["id"]);
    $status     = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";
    
    $query  = mysqli_query($__CONEXAO__, "select * from eventos where nome='$nome'");

    $arr = array(
        "id"        => $decEvento,
        "nome"      => $nome,
        "categoria" => $categoria,
        "turmasQt"  => mysqli_num_rows($query),
        "status"    => $status
    );
    array_push($array, $arr);
}

endCode($array, true);