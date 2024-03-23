<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$getMyProfile = mysqli_query($__CONEXAO__, "select * from users where type='$__TYPE__' and id='$__ID__'");

$infosArr = array();

while($dados = mysqli_fetch_array($getMyProfile)){
    $id             = $dados["id"];
    $cpf            = decrypt($dados["cpf"]);
    $nome           = decrypt($dados["nome"]);
    $email          = decrypt($dados["email"]);
    $imagem         = decrypt($dados["imagem"]);
    $curriculo      = decrypt($dados["curriculo"]);
    $nascimento     = decrypt($dados["nascimento"]);
    $titularidade   = decrypt($dados["titularidade"]);

    $infosArr = array(
        "id"=>$id,
        "cpf"=>$cpf,
        "nome"=>$nome,
        "email"=>$email,
        "imagem"=>$imagem,
        "curriculo"=>$curriculo,
        "nascimento"=>$nascimento,
        "titularidade"=>$titularidade
    )
}

endCode($infosArr, true);