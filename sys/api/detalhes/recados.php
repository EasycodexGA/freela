<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$recadoID  = scapeString($__CONEXAO__, $_GET['id']);

$_query_ = mysqli_query($__CONEXAO__, "select * from recados where id='$recadoID'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $id     = $_dados_["id"];
    $title  = decrypt($_dados_["title"]);
    $desc   = decrypt($_dados_["descricao"]);
    $from   = $_dados_["fromid"];
    $type   = $_dados_["type"];
    $to     = $_dados_["toid"];
    $time   = $_dados_["time"];
    $status = $_dados_["active"];

    $getFrom = mysqli_query($__CONEXAO__, "select nome from users where id='$from'");
    $from = mysqli_fetch_assoc($getFrom);
    $from = decrypt($from["nome"]);

    if($type == "1"){
        $getTo = mysqli_query($__CONEXAO__, "select nome from users where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
        $type = "Aluno";
    }

    if($type == "2"){
        $getTo = mysqli_query($__CONEXAO__, "select nome from turmas where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
        $type = "Turma";
    }

    if($type == "3"){
        $to = "Todos";
        $type = "Geral";
    }

    if($type == "4"){
        $getTo = mysqli_query($__CONEXAO__, "select nome from equipes where id='$to'");
        $to = mysqli_fetch_assoc($getTo);
        $to = decrypt($to["nome"]);
        $type = "Equipe";
    }
    

    $status = $status == '1' ? "active" : "inactive";

    $arrTurmas = array();

    while($dados = mysqli_fetch_array($query)){
        $turmaId        = $dados['turma'];
        $query2         = mysqli_query($__CONEXAO__, "select nome from turmas where id='$turmaId'");
        $turma          = mysqli_fetch_assoc($query2)['nome'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId));
    }

    $arr = array(
        "id"        => $id,
        "title"     => $title,
        "from"      => $from,
        "desc"      => $desc,
        "to"        => $to,
        "type"      => $type,
        "data"      => $time,
        "status"    => $status,
    );
    array_push($array, $arr);
}

endCode($array, true);