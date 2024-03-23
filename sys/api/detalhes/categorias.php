<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$id  = scapeString($__CONEXAO__, $_GET['id']);
$id  = setNum($id);
$id = decrypt($id);
$_query_ = mysqli_query($__CONEXAO__, "select * from categorias where id='$id'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $nome   = decrypt($_dados_["nome"]);
    $status = $_dados_["active"];


    $query = mysqli_query($__CONEXAO__, "select id, nome from turmas where categoria='$id'");
    $turmas = array();
    for($dados = mysqli_fetch_array($query)){
        $idT = $dados['id'];
        $nomeT = decrypt($dados['nome']);
        array_push($turmas, array("id"=>$idT, "nome"=>$nomeT));
    }

    $status = $status == '1' ? "active" : "inactive";

    $arr = array(
        "id"        => $id,
        "nome"      => $nome,
        "turmas"    => $turmas,
        "status"    => $status
    );
    array_push($array, $arr);
}

endCode($array, true);