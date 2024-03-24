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

    $query  = mysqli_query($__CONEXAO__, "select id, nome from turmas where id in (select turma from professores where email='$email')");
    
    $arrTurmas = array();

    while($dados = mysqli_fetch_array($query)){
        $turma      = $dados['nome'];
        $turmaId    = $dados['id'];
        
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId, "checked"=>1));
    }

    $allTurmas = array();
    $query2 = mysqli_query($__CONEXAO__, "select id, nome from turmas where id not in (select turma from professores where email='$email')");

    while($dados3 = mysqli_fetch_array($query2)){
        $turma3      = $dados3['nome'];
        $turmaId3    = $dados3['id'];
        array_push($allTurmas, array("nome"=>decrypt($turma3), "id"=>$turmaId3, "checked"=>0));
    }

    $turmas = array_merge($arrTurmas, $allTurmas);

    $arr = array(
        "id"            => $decProfissional,
        "imagem"        => $imagem,
        "nome"          => $nome, 
        "titularidade"  => $titularidade,
        "email"         => decrypt($email),
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $turmas,
        "curriculo"     => $curriculo,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);