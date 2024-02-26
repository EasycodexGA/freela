<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$profissional  = scapeString($__CONEXAO__, $_GET['id']);
$profissional = setNum($profissional);
$decProfissional = decrypt($profissional);

$_query_ = mysqli_query($__CONEXAO__, "select * from users where id='$decProfissional'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $cpf        = decrypt($_dados_["cpf"]);
    $nascimento = decrypt($_dados_["nascimento"]);
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";

    $query  = mysqli_query($__CONEXAO__, "select * from professores where email='$email'");

    $dados = mysqli_fetch_assoc($query);

    $email          = decrypt($dados["email"]);
    $imagem         = decrypt($dados["imagem"]);
    $titularidade   = decrypt($dados["titularidade"]);

    $arrTurmas = array();

    while($dados2 = mysqli_fetch_array($query)){
        $turmaId    = decrypt($dados2['turma']);
        $query2     = mysqli_query($__CONEXAO__, "select * from turmas where id='$turmaId'");
        $turma      = mysqli_fetch_assoc($query2)['nome'];
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