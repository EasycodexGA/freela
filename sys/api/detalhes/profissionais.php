<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$profissional  = scapeString($__CONEXAO__, $_GET['id']);
$profissional = setNum($profissional);
$decProfissional = decrypt($profissional);

$_query_ = mysqli_query($__CONEXAO__, "select * from users where id='$decProfissional'");

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $email          = decrypt($dados["email"]);
    $imagem           = decrypt($dados["imagem"]);
    $titularidade   = decrypt($dados["titularidade"]);

    $query  = mysqli_query($__CONEXAO__, "select * from users where email='$email'");

    $cpf        = decrypt($query["cpf"]);
    $nascimento = decrypt($query["nascimento"]);
    $status     = $query["active"];

    $status = $status == '1' ? "active" : "inactive";

    $query2 = mysqli_query($__CONEXAO__, "select * from professores where email='$email'");

    $arrTurmas = array();

    while($dados2 = mysqli_fetch_array($query2)){
        $turmaId    = decrypt($dados2['turma']);
        $query3     = mysqli_query($__CONEXAO__, "select * from turmas where id='$turmaId'");
        $turma      = mysqli_fetch_assoc($query3)['nome'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId));
    }

    $arr = array(
        "id"            => $decProfissional,
        "nome"          => $nome, 
        "titularidade"  => $titularidade,
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $arrTurmas,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);