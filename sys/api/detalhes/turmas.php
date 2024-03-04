<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$turma  = scapeString($__CONEXAO__, $_GET['id']);
$turma = setNum($turma);
$decTurma = decrypt($turma);

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma' and id in (select turma from $table where email='$__EMAIL__')");
}

if(mysqli_num_rows($_query_) < 1){
    endCode('Essa turma não existe ou você não está participando dela.', false);
}

$array = array();
while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $categoria  = $_dados_["categoria"];
    $horario    = $_dados_["horario"];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select nome from users where email in (select email from alunos where turma='$decTurma'");
    $query2 = mysqli_query($__CONEXAO__, "select nome, imagem from users where email in (select email from professores where turma='$decTurma')");

    $arrAlunos = array();
    $arrProf = array();

    while($dados = mysqli_fetch_array($query)){
        $nomeA = decrypt($dados['nome']);
        array_push($arrAlunos, array("nome"=>$nomeA));
    }

    while($dados2 = mysqli_fetch_array($query2)){
        $nomeP = decrypt($dados2['nome']);
        $imagem = decrypt($dados2['imagem']);
        array_push($arrProf, array("nome"=>$nomeP, "imagem"=>$imagem));
    }

    $arr = array(
        "id"                => $decTurma,
        "nome"              => $nome, 
        "categoria"         => $categoria,
        "alunos"            => $arrAlunos,
        "horario"           => converterHora($horario),
        "profissionais"     => $arrProf,
        "profissionaisQt"   => mysqli_num_rows($query2),
        "alunosQt"          => mysqli_num_rows($query),
        "status"            => $status
    );
    array_push($array, $arr);
}

endCode($array, true);