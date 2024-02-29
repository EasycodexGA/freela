<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$evento  = scapeString($__CONEXAO__, $_GET['id']);
$evento = setNum($evento);
$decEvento = decrypt($evento);

$_query_ = mysqli_query($__CONEXAO__, "select nome, categoria, status, turma from eventos where id='$decEvento'");
$turmaEvento = mysqli_fetch_assoc($_query_)['turma'];

if($__TYPE__ < 3) {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $query = mysqli_query($__CONEXAO__, "select * from $table where email='$__EMAIL__' and turma='$turmaEvento'");

    if(mysqli_num_rows($query) < 1){
        endCode("Você não está participando desse evento", false);
    }

    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos where turma='$turmaEvento'");
}

$array = array();

$turmas = array();
while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $categoria  = decrypt($_dados_["categoria"]);
    $status     = $_dados_["active"];

    $status = $status == '1' ? "active" : "inactive";
    
    $query  = mysqli_query($__CONEXAO__, "select id from eventos where nome='$nome'");

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