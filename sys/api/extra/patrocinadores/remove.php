<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id  = scapeString($__CONEXAO__, $json->id);

$id = setNum($id);

checkMissing(
    array(
        $id
    )
);

$id = decrypt($id);

$check = mysqli_query($__CONEXAO__, "select id from patrocinadores where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Imagem inexistente", false);
}

$img = mysqli_fetch_assoc($check)["img"];
$img = decrypt($img);

$caminho = "../../../../imagens/patrocinadores";

if(unlink("$caminho/$img")){
    mysqli_query($__CONEXAO__, "delete from patrocinadores where id='$id'");
    endCode("Imagem excluida", true);
} else {
    endCode("Erro ao excluir imagem / caminho/$img", false);

};
