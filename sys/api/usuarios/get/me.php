<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$getMyProfile = mysqli_query($__CONEXAO__, "select * from users where typeC='$__TYPE__' and id='$__ID__'");

$infosArr = array();

while($dados = mysqli_fetch_array($getMyProfile)){
    $id             = $dados["id"];
    $type           = $dados["typeC"];
    $cpf            = decrypt($dados["cpf"]);
    $nome           = decrypt($dados["nome"]);
    $email          = decrypt($dados["email"]);
    $imagem         = decrypt($dados["imagem"]);
    $curriculo      = decrypt($dados["curriculo"]);
    $nascimento     = decrypt($dados["nascimento"]);
    $titularidade   = decrypt($dados["titularidade"]);

    if($type == "1"){
        $type = "Aluno";
    }

    if($type == "2"){
        $type = "Profissional";
    }

    if($type == "3"){
        $type = "Administrador";
    }

    $infosArr = array(
        "id"=>$id,
        "cpf"=>$cpf,
        "nome"=>$nome,
        "type"=>$type,
        "email"=>$email,
        "nascimento"=>$nascimento,
    );

    if($__TYPE__ == 2){
        array_push($infosArr, array(
            "imagem"=>$imagem,
            "curriculo"=>$curriculo,
            "titularidade"=>$titularidade
        ));
    }
}

endCode($infosArr, true);