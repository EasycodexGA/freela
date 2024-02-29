<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where idEnc in (select turma from $table where email='$__EMAIL__')");
    // coloquei um idEnc na tabela turma, mas é mais facil tirar o encrypt dos outros lugares, outra hora faço isso
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome = decrypt($dados["nome"]);
    $categoria = $dados["categoria"];

    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $idC = encrypt($dados["id"]);

    $query = mysqli_query($__CONEXAO__, "select id from alunos where turma='$idC'");
    $query2 = mysqli_query($__CONEXAO__, "select id from professores where turma='$idC'");

    $arr = array(
        "id"            => $dados["id"], 
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