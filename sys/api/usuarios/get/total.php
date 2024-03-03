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

endCode($type, false);

$pode = array("usersalunos", "turmas", "categorias", "eventos", "usersprofessor");

if(!in_array($type, $pode)){
    endCode("Pesquisa inválida.", false);
}

if($__TYPE__ < 3){
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';

    if($type == "usersalunos"){
        $type = "users where typeC='1' and email in (select email from alunos where turma in (select turma from professores where email='$__EMAIL__'))";
    }
    
    if($type == 'eventos'){
        $type = "eventos where turma in (select turma from $table where email='$__EMAIL__')";
    }
    
    if($type == 'turmas'){
        $type = "turmas where id in (select turma from $table where email='$__EMAIL__')";
    }
} else {
    if($type == "usersprofessor"){
        $type = "users where typeC='2'";
    }

    if($type == "usersalunos"){
        $type = "users where typeC='1'";
    }
    
    if($type == 'eventos'){
        $type = "eventos";
    }
    
    if($type == 'turmas'){
        $type = "turmas";
    }
}

$query = mysqli_query($__CONEXAO__, "select active, id from $type") or die("erro");
$active = 0; //dei truncate em tudo      
$inactive = 0;

while($dados = mysqli_fetch_array($query)){
    $act = $dados['active'];
    $id = $dados['id'];

    if($act == '1'){
        $active++;
    } else {
        $inactive++;
    }
}
// call
endCode(array("active"=>$active, "inactive"=>$inactive, "turmas"=>$turmas, "id"=> $id), true);