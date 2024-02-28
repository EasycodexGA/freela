<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

header('Content-Type: application/json; charset=utf-8');

$request    = file_get_contents('php://input');
$json       = json_decode($request);

$type       = scapeString($__CONEXAO__, $json->type);

$type       = setString($type);

checkMissing(
    array(
        $type
    )
);

$type = decrypt($type);

if($type == 'turmas'){
    $turmas = array();
    if($__TYPE__ < 3){
        $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
        $query = mysqli_query($__CONEXAO__, "select turma from $table where email='$__EMAIL__'");
        while($getQuery = mysqli_fetch_array($query)){
            array_push($turmas, decrypt($getQuery['turma']));
        }
    }
}

if($type == 'eventos'){
    $turmass = '';
    if($__TYPE__ < 3){
        $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
        $query = mysqli_query($__CONEXAO__, "select turma from $table where email='$__EMAIL__'");
        while($getQuery = mysqli_fetch_array($query)){
            $turmass .= ',' . decrypt($getQuery['turma']) . ',';
        }
    }
    endCode($turmass, false);
    $eventos = array();
    $query = mysqli_query($__CONEXAO__, "select id from eventos where turma in $turmass");
    while($getQuery = mysqli_fetch_array($query)){
        array_push($eventos, $getQuery['id']);
    }
}

$pode = array("users", "turmas", "categorias", "eventos");

if($type == "usersprofessor"){
    $type = "users where typeC='2'";
}

if($type == "usersalunos"){
    $type = "users where typeC='1'";
}

if(!in_array($type, $pode)){
    endCode("Pesquisa inválida.", false);
}

$query = mysqli_query($__CONEXAO__, "select active, id from $type") or die("erro");
$active = 0;
$inactive = 0;

while($dados = mysqli_fetch_array($query)){
    $act = $dados['active'];
    $id = $dados['id'];

    if($turmas){
        if(in_array($id, $turmas)){
            if($act == '1'){
                $active++;
            } else {
                $inactive++;
            }
        }
    } else {
        if($act == '1'){
            $active++;
        } else {
            $inactive++;
        }
    }
}

endCode(array("active"=>$active, "inactive"=>$inactive, "turmas"=>$turmas, "id"=> $id), true);