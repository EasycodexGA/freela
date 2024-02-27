<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$turma  = scapeString($__CONEXAO__, $_GET['id']);
$turma = setNum($turma);
$decTurma = decrypt($turma);

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'");
} else {
    $_query_ = checkTurma($__CONEXAO__, $__TYPE__, $__EMAIL__, $decTurma);
}

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $categoria  = decrypt($_dados_["categoria"]);
    $data       = $_dados_['data'];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";
    
    $query = mysqli_query($__CONEXAO__, "select * from alunos where turma='$turma'");
    $query2 = mysqli_query($__CONEXAO__, "select * from professores where turma='$turma'");

    $arrAlunos = array();
    $arrProf = array();

    while($dados = mysqli_fetch_array($query)){
        $emailA = $dados['email'];
        $alunos_users = mysqli_query($__CONEXAO__, "select * from users where email='$emailA'");
        $nomeA = mysqli_fetch_assoc($alunos_users)['nome'];
        array_push($arrAlunos, array("nome"=>decrypt($nomeA)));
    }

    while($dados2 = mysqli_fetch_array($query2)){
        $emailP = $dados2['email'];
        $prof_users = mysqli_query($__CONEXAO__, "select * from users where email='$emailP'");
        $nomeP = mysqli_fetch_assoc($prof_users)['nome'];
        $imagem = mysqli_fetch_assoc($prof_users)['imagem'];
        array_push($arrProf, array("nome"=>decrypt($nomeP), "imagem"=>decrypt($imagem)));
    }

    $arr = array(
        "id"                => $decTurma,
        "nome"              => $nome, 
        "categoria"         => $categoria,
        "alunos"            => $arrAlunos,
        "data"              => $data,
        "profissionais"     => $arrProf,
        "profissionaisQt"   => mysqli_num_rows($query2),
        "alunosQt"          => mysqli_num_rows($query),
        "status"            => $status
    );
    array_push($array, $arr);
}

endCode($array, true);