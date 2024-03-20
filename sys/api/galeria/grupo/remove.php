<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$id = scapeString($__CONEXAO__, $json->id);
$id = setNum($id);

checkMissing(
    array(
        $id
    )
);

$id = decrypt($id);

$check = mysqli_query($__CONEXAO__, "select id from grupoimagem where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Esse grupo não existe.", false);
}

$getAllImgs = mysqli_query($__CONEXAO__, "select id, img from imagensgp where grupo='$id'");

$caminho = "../../../../imagens/galeria";

while($dados = mysqli_fetch_array($getAllImgs)){
    $img = decrypt($dados["img"]);
    $idImg = $dados["id"];

    if(!unlink("$caminho/$img")){ 
        endCode("Erro ao excluir: $img", false);
    }

    mysqli_query($__CONEXAO__, "delete from imagensgp where grupo='$id' and id='$idImg'");
    usleep(50000)
}

mysqli_query($__CONEXAO__, "delete from grupoimagem where id='$id'");

endCode("Sucesso ao excluir!", true);