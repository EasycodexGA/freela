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


    $queryEventos  = mysqli_query($__CONEXAO__, "select turmas, equipes from eventos where nome='$nome' and data='$data'");
    $assocEventos = mysqli_fetch_assoc($queryEventos);


    $thisTurmas = $assocEventos['turmas'];
    $thisTurmas = $thisTurmas != ','   or strlen($thisTurmas) > 0 ? substr($thisTurmas, 1) : "''";

    $thisEquipes = $assocEventos['equipes'];
    $thisEquipes = $thisEquipes != ','  or strlen($thisEquipes) > 0 ? substr($thisEquipes, 1) : "''";


    $arrTurmas = array();
    $allTurmas = array();

    $arrEquipe = array();
    $allEquipes = array();


    $queryT = mysqli_query($__CONEXAO__, "select id, nome from turmas where id in ($thisTurmas)") or die ("asd".$thisbb);

    $queryNotT = mysqli_query($__CONEXAO__, "select id, nome from turmas where id not in ($thisTurmas)") or die('bbb');

    $queryE = mysqli_query($__CONEXAO__, "select id, nome from equipes where id in ($thisEquipes)");
    $queryNotE = mysqli_query($__CONEXAO__, "select id, nome from equipes where id not in ($thisEquipes)");


    while($dadosT = mysqli_fetch_array($queryT)){
        $turma      = $dadosT['nome'];
        $turmaId    = $dadosT['id'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId, "checked"=>1));
    }

    while($dadosNotT = mysqli_fetch_array($queryNotT)){
        $turmaNot       = $dadosNotT['nome'];
        $turmaIdNot     = $dadosNotT['id'];
        array_push($allTurmas, array("nome"=>decrypt($turmaNot), "id"=>$turmaIdNot, "checked"=>0));
    }

    while($dadosE = mysqli_fetch_array($queryE)){
        $equipe     = $dadosE['nome'];
        $equipeId   = $dadosE['id'];
        
        array_push($arrEquipe, array("nome"=>decrypt($equipe), "id"=>$equipeId, "checked"=>1));
    }

    while($dadosNotE = mysqli_fetch_array($queryNotE)){
        $equipeNot      = $dadosNotE['nome'];
        $equipeIdNot    = $dadosNotE['id'];
        array_push($allEquipes, array("nome"=>decrypt($equipeNot), "id"=>$equipeIdNot, "checked"=>0));
    }


    $turmas = array_merge($arrTurmas, $allTurmas);
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