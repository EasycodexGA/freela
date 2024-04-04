<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$complemento = '';

if($__TYPE__ > 1){
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes");
} else {
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes where id in (select equipe from alunos where email='$__EMAIL__')");
}

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $id     = $_dados_["id"];
    $nome   = decrypt($_dados_["nome"]);
    $status = $_dados_["active"];
    $status = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id from alunos where equipe='$id'");

    $arr = array(
        "id"            => $id,
        "nome"          => $nome,
        "alunos"        => mysqli_num_rows($query),
        "status"        => $status,
        "_name"         => "equipes"
    );
    array_push($array, $arr);
}

endCode($array, true);