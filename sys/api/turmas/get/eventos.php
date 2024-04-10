<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from eventos");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select eventos.* from eventos join $table on cast(eventos.turmas as char) like concat('%,',$table.turma,',%') where $table.email='$__EMAIL__'");
}

var_dump($__EMAIL__);

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $data       = $dados["data"];
    $status     = $dados["active"]; 
    $status     = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $dados["id"], 
        "nome"      => $nome,
        "data"      => $data,
        "status"    => $status,
        "_name"     => "eventos"
    );
    array_push($array, $arr);
}

endCode($array, true);