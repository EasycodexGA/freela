<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$evento  = scapeString($__CONEXAO__, $_GET['id']);
$evento = setNum($evento);
$decEvento = decrypt($evento);


if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos where id='$decEvento'");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos where id='$decEvento' and turma in (select turma from $table where email='$__EMAIL__')");
}

if(mysqli_num_rows($_query_) < 1){
    endCode('Este evento não existe ou você não está participando dele.', false);
}

$array = array();

$turmas = array();
while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $turma      = $_dados_['turma'];
    $descricao  = $_dados_['descricao'];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";

    $getCat     = mysqli_query($__CONEXAO__, "select categoria from turma where id='$turma'");
    $categoria  = mysqli_fetch_assoc($getCat)["categoria"];

    $arr = array(
        "id"        => $decEvento,
        "nome"      => $nome,
        "turma"     => $turma,
        "categoria" => $categoria,
        "descricao" => $descricao,
        "turmasQt"  => mysqli_num_rows($query),
        "status"    => $status
    );
    array_push($array, $arr);
}

endCode($array, true);