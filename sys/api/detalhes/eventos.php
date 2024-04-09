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
    $descricao  = decrypt($_dados_['descricao']);
    $data       = $_dados_['data'];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";
    $created     = $_dados_['created'];


    $query  = mysqli_query($__CONEXAO__, "select id, nome from turmas where id in (select turma from eventos where nome='$nome' and data='$data')");
    
    $arrTurmas = array();

    while($dados = mysqli_fetch_array($query)){
        $turma      = $dados['nome'];
        $turmaId    = $dados['id'];
        
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId, "checked"=>1));
    }

    $allTurmas = array();
    $query3 = mysqli_query($__CONEXAO__, "select id, nome from turmas where id not in (select turma from eventos where nome='$nome' and data='$data')");

    while($dados3 = mysqli_fetch_array($query3)){
        $turma3      = $dados3['nome'];
        $turmaId3    = $dados3['id'];
        array_push($allTurmas, array("nome"=>decrypt($turma3), "id"=>$turmaId3, "checked"=>0));
    }

    $turmas = array_merge($arrTurmas, $allTurmas);

    $query4  = mysqli_query($__CONEXAO__, "select id, nome from equipes where id in (select equipe from eventos where nome='$nome' and data='$data')");
    $arrEquipe = array();

    while($dados4 = mysqli_fetch_array($query4)){
        $equipe      = $dados4['nome'];
        $equipeId    = $dados4['id'];
        
        array_push($arrEquipe, array("nome"=>decrypt($equipe), "id"=>$equipeId, "checked"=>1));
    }

    $allEquipes = array();
    $query5 = mysqli_query($__CONEXAO__, "select id, nome from equipes where id not in (select equipe from eventos where nome='$nome' and data='$data')");

    while($dados5 = mysqli_fetch_array($query5)){
        $equipe2      = $dados5['nome'];
        $equipeId2    = $dados5['id'];
        array_push($allEquipes, array("nome"=>decrypt($equipe2), "id"=>$equipeId2, "checked"=>0));
    }

    $equipes = array_merge($arrEquipe, $allEquipes);

    $arr = array(
        "id"        => $decEvento,
        "nome"      => decrypt($nome),
        "data"      => $data,
        "turmas"    => $turmas,
        "equipes"   => $equipes,
        "status"    => $status,
        "descricao" => $descricao,
    );
    array_push($array, $arr);
}

endCode($array, true);