<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 0);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turma  = scapeString($__CONEXAO__, $json->turma);
$turma = setNoXss($turma);
$decTurma = decrypt($turma);

if($__TYPE__ == 2){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'");
} else {
    $table = 'alunos';
    if($__TYPE__ == 1){
        $table = 'professores';
    }
    $query = mysqli_query($__CONEXAO__, "select * from $table where email='$__EMAIL__'");
    $turmas = array();
    while($getQuery = mysqli_fetch_array($query)){
        $value = $getQuery['turma'];
        $valuedec = decrypt($value);
        array_push($turmas, $valuedec);
    }
    if(!in_array($decTurma, $turmas)){
        endCode('Você não está nessa turma.', false);
    }
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome       = decrypt($dados["nome"]);
    $categoria  = decrypt($dados["categoria"]);
    $idC        = encrypt($dados["id"]);
    $status     = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";
    
    $query = mysqli_query($__CONEXAO__, "select * from alunos where turma='$idC'");
    $query2 = mysqli_query($__CONEXAO__, "select * from professores where turma='$idC'");

    $arrAlunos = array();
    $arrProf = array();

    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "categoria"     => $categoria,
        "profissionaisQt" => mysqli_num_rows($query2),
        "alunosQt"        => mysqli_num_rows($query),
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);