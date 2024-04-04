<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id in (select turma from $table where email='$__EMAIL__')");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $id     = $dados["id"];
    $nome   = decrypt($dados["nome"]);
    $catId  = $dados["categoria"];  

    $getCat     = mysqli_query($__CONEXAO__, "select nome from categorias where id='$catId'");
    $categoria  = mysqli_fetch_assoc($getCat)["nome"];
    $categoria  = decrypt($categoria);

    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from alunos where turma='$id'");
    $query2 = mysqli_query($__CONEXAO__, "select id from professores where turma='$id'");

    $arr = array(
        "id"            => $id, 
        "nome"          => $nome, 
        "categoria"     => $categoria,
        "profissionais" => mysqli_num_rows($query2),
        "alunos"        => mysqli_num_rows($query),
        "status"        => $status,
        "_name"         => "turmas"
    );
    array_push($array, $arr);
}

endCode($array, true);