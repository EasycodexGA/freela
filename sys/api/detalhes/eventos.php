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
    $_query_ = mysqli_query($__CONEXAO__, "select distinct eventos.* from eventos join $table on cast(eventos.turmas as char) like concat('%,',$table.turma,',%') or cast(eventos.equipes as char) like concat('%,',$table.equipe,',%') where $table.email='$__EMAIL__' and eventos.id='$decEvento'");
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
    $thisTurmas = substr($thisTurmas, 1);
    $thisTurmas = strlen($thisTurmas) > 0 ? array_map('intval', explode(',', $thisTurmas)) : "";
    $thisTurmas = implode("','", $thisTurmas);

    $thisEquipes = $assocEventos['equipes'];
    $thisEquipes = substr($thisEquipes, 1);
    $thisEquipes = strlen($thisEquipes) > 0 ? array_map('intval', explode(',', $thisEquipes)) : "";
    $thisEquipes = implode("','", $thisEquipes);


    $arrTurmas = array();
    $allTurmas = array();

    $arrEquipe = array();
    $allEquipes = array();


    $queryT = mysqli_query($__CONEXAO__, "select id, nome, categoria from turmas where id in ('".$thisTurmas."')") or die ("asd".$thisbb);

    $queryNotT = mysqli_query($__CONEXAO__, "select id, nome, categoria from turmas where id not in ('".$thisTurmas."')") or die('bbb');

    $queryE = mysqli_query($__CONEXAO__, "select id, nome from equipes where id in ('".$thisEquipes."')");
    $queryNotE = mysqli_query($__CONEXAO__, "select id, nome from equipes where id not in ('".$thisEquipes."')");


    while($dadosT = mysqli_fetch_array($queryT)){
        $turma      = $dadosT['nome'];
        $turmaId    = $dadosT['id'];
        $categoriaT = $dadosT['categoria'];

        $query5T = mysqli_query($__CONEXAO__, "select nome from categorias where id='$categoriaT'");
        $nomeCatT = mysqli_fetch_assoc($query5T)['nome'];

        array_push($arrTurmas, array("nome"=>decrypt($turma) . " - " . decrypt($nomeCatT), "id"=>$turmaId, "checked"=>1));
    }

    while($dadosNotT = mysqli_fetch_array($queryNotT)){
        $turmaNot       = $dadosNotT['nome'];
        $turmaIdNot     = $dadosNotT['id'];
        $categoriaNot     = $dadosNotT['categoria'];

        $query5Not = mysqli_query($__CONEXAO__, "select nome from categorias where id='$categoriaNot'");
        $nomeCatNot = mysqli_fetch_assoc($query5Not)['nome'];

        array_push($allTurmas, array("nome"=>decrypt($turmaNot) . " - " . decrypt($nomeCatNot), "id"=>$turmaIdNot, "checked"=>0));
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