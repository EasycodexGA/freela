<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$todosRecados = array();

$temp = $__TIME__ - 8600;
$getRecados = $__TYPE__ == 1 ? mysqli_query($__CONEXAO__, "select * from recados where time>'$temp' and type='1' and toid='$__ID__' or time>'$temp' and type='2' and toid in (select id from turmas where id in (select turma from alunos where email='$__EMAIL__')) or time>'$temp' and type='4' and toid in (select id from equipes where id in (select equipe from alunos where email='$__EMAIL__')) or time>'$temp' and type='3' and toid='0'") : "";

while($dados = mysqli_fetch_array($getRecados)){
    $id  = $dados["id"];
    $title  = decrypt($dados["title"]);
    $desc   = decrypt($dados["descricao"]);
    $time   = $dados["time"];
    $from   = $dados["fromid"];

    $getFrom = mysqli_query($__CONEXAO__, "select nome from users where id='$from'");
    $from = mysqli_fetch_assoc($getFrom);
    $from = decrypt($from["nome"]);

    array_push($todosRecados, array(
        "id"=>$id,
        "title"=>$title,
        "desc"=>$desc,
        "time"=>$time,
        "from"=>$from
    ));
}

endCode($todosRecados, true);