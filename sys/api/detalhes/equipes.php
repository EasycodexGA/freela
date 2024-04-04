<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$equipe  = scapeString($__CONEXAO__, $_GET['id']);
$equipe = setNum($equipe);
$decEquipe = decrypt($equipe);

if($__TYPE__ > 1){
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes where id='$decEquipe'") or die("1");
} else {
    $_query_ = mysqli_query($__CONEXAO__, "select * from equipes where id='$decTurma'and id in (select equipe from users where email='$__EMAIL__')") or die("2");
}

if(mysqli_num_rows($_query_) < 1){
    endCode('Essa equipe não existe ou você não está participando dela.', false);
}

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $id     = $_dados_["id"];
    $nome   = decrypt($_dados_["nome"]);
    $status = $_dados_["active"];
    $status = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id, nome from users where email in (select email from alunos where equipe='$id')");
    $alunosArr = array();

    while($dados = mysqli_fetch_array($query)){
        $idA    = $dados['id'];
        $nomeA  = $dados['nome'];

        array_push($alunosArr, array("id"=>$idA, "nome"=>decrypt($nomeA)));
    }

    $arr = array(
        "id"            => $id,
        "nome"          => $nome,
        "alunos"        => $alunosArr,
        "status"        => $status,
    );
    array_push($array, $arr);
}

endCode($array, true);