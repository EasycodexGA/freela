<?php
include '../../../conexao.php';

header('Content-Type: application/json; charset=utf-8');

$getAll = mysqli_query($__CONEXAO__, "select * from grupoimagem");

$nomes = array();

while($dados = mysqli_fetch_array($getAll)){
    $id     = $dados["id"];
    $nomeGp = decrypt($dados["nome"]);

    $allImgs = array();

    $getImgs = mysqli_query($__CONEXAO__, "select id,img from imagensgp where grupo='$id'");

    while($d = mysqli_fetch_array($getImgs)){
        $idD    = $d['id'];
        $imgD   = decrypt($d['img']);

        array_push($allImgs, array("id"=>$idD, "imagem"=>"$__WEB__/imagens/galeria/$img$imgD"));
    }

    array_push(
        $nomes, 
        array("id"=>$id, "nome"=>$nomeGp, "imagens"=>$allImgs)
    );
}

endCode($nomes, true);