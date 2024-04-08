<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes where id in (select equipe from $table where email='$__EMAIL__')");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $id     = $dados["id"];
    $nome   = decrypt($dados["nome"]);
    
    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from alunos where equipe='$id' and email in (select email from users where active='1' and typeC='1')");

    $arr = array(
        "id"            => $id, 
        "nome"          => $nome, 
        "alunos"        => mysqli_num_rows($query),
        "status"        => $status,
        "_name"         => "turmas"
    );
    array_push($array, $arr);
}

endCode($array, true);