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
    $nome       = $_dados_["nome"];
    $descricao  = $_dados_['descricao'];
    $data       = $_dados_['data'];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";
    $crated     = $_dados_['created'];


    $getCat     = mysqli_query($__CONEXAO__, "select categoria from turma where id='$turma'");
    $categoria  = mysqli_fetch_assoc($getCat)["categoria"];

    $turmas = array();
    $getTurmas = mysqli_query($__CONEXAO__, "select id, nome, categoria from turma where (select turma from eventos where nome='$nome' and data='$data')");
    while($dadosTurmas = mysqli_fetch_array($getTurmas)){
        $nomeT      = $dadosTurmas['nome'];
        $idT        = $dadosTurmas['id'];
        $categoriaT = $dadosTurmas['categoria'];
        array_push($turmas, {"id"=> $idT, "nome"=> $nomeT, "categoria"=> $categoriaT})
    }

    $arr = array(
        "id"        => $decEvento,
        "nome"      => decrypt($nome),
        "turmas"    => $turmas,
        "categoria" => $categoria,
        "descricao" => $descricao,
        "turmasQt"  => mysqli_num_rows($query),
        "status"    => $status,
        "created"   => $created
    );
    array_push($array, $arr);
}

endCode($array, true);