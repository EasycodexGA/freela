<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$id     = scapeString($__CONEXAO__, $_GET['id']);
$id     = setNum($id);
$id     = decrypt($id);
$_query_ = mysqli_query($__CONEXAO__, "select * from rifas where id='$id'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $qt         = decrypt($_dados_["qt"]);
    $nome       = decrypt($_dados_["nome"]);
    $desc       = decrypt($_dados_["desc"]);
    $valor      = decrypt($_dados_["valor"]);
    $premios    = json_decode($_dados_["premios"]);

    foreach($premios as &$i){
        $i->nome = decrypt($i->nome);
    }

    $nums = array();

    $query = mysqli_query($__CONEXAO__, "select num from numerorifa where ref='$id' order by asc");
    while($dados = mysqli_fetch_array($query)){
        $num = $dados['num'];
        array_push($nums, $num);
    }


    $arr = array(
        "id"        => $id,
        "nome"      => $nome,
        "desc"      => $desc,
        "premios"   => $premios,
        "qt"        => $qt,
        "valor"     => $valor,
        "selected"  => $nums
    );
    array_push($array, $arr);
}

endCode($array, true);