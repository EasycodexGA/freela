<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

$profissional  = scapeString($__CONEXAO__, $_GET['id']);
$profissional = setNum($profissional);
$decProfissional = decrypt($profissional);

$_query_ = mysqli_query($__CONEXAO__, "select * from users where id='$decProfissional'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $nome           = decrypt($_dados_["nome"]);
    $cpf            = decrypt($_dados_["cpf"]);
    $nascimento     = decrypt($_dados_["nascimento"]);
    $titularidade   = decrypt($_dados_["titularidade"]);
    $imagem         = decrypt($_dados_["imagem"]);
    $curriculo      = decrypt($_dados_["curriculo"]);
    $email          = $_dados_["email"];
    $status         = $_dados_["active"];
    $status         = $status == '1' ? "active" : "inactive";

    $query  = mysqli_query($__CONEXAO__, "select turma from professores where email='$email'");

    $email = decrypt($email);

    $arrTurmas = array();

    while($dados = mysqli_fetch_array($query)){
        $turmaId        = $dados['turma'];
        $query2         = mysqli_query($__CONEXAO__, "select nome from turmas where id='$turmaId'");
        $turma          = mysqli_fetch_assoc($query2)['nome'];
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId));
    }

    $arr = array(
        "id"            => $decProfissional,
        "nome"          => $nome, 
        "titularidade"  => $titularidade,
        "email"         => $email,
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $arrTurmas,
        "curriculo"     => $curriculo,
        "imagem"        => $imagem,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);