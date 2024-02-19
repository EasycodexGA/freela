<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 0);

$_query_ = mysqli_query($__CONEXAO__, "select * from turmas");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome = decrypt($dados["nome"]);
    $categoria = decrypt($dados["categoria"]);

    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $idC = encrypt($dados["id"]);

    $query = mysqli_query($__CONEXAO__, "select id from alunos where turma='$idC'");
    
    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "categoria"     => $categoria,
        "alunos"        => mysqli_num_rows($query),
        "profissionais" => 0,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);