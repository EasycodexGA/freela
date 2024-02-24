<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 0);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$turma  = scapeString($__CONEXAO__, $json->turma);
$turma = setNum($turma);
$decTurma = decrypt($turma);

if($__TYPE__ == 2){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'");
} else {
    checkTurma($decTurma, "Você não está nessa turma.", "turmas where id='$decTurma'");
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

    while($dados2 = mysqli_fetch_array($query)){
        $nome = decrypt($dados2['nome']);
        array_push($arrAlunos, array("nome"=>$nome));
    }

    while($dados3 = mysqli_fetch_array($query2)){
        $nome = decrypt($dados3['nome']);
        $imagem = decrypt($dados3['imagem']);
        array_push($arrProf, array("nome"=>$nome, "imagem"=>$imagem));
    }

    $arr = array(
        "id"                => $decTurma,
        "nome"              => $nome, 
        "categoria"         => $categoria,
        "alunos"            => $arrAlunos,
        "profissionais"     => $arrProf,
        "profissionaisQt"   => mysqli_num_rows($query2),
        "alunosQt"          => mysqli_num_rows($query),
        "status"            => $status
    );
    array_push($array, $arr);
}

endCode($array, true);