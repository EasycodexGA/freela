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

$check = mysqli_query($__CONEXAO__, "select nome from imagensgp where id='$id'");

if(mysqli_num_rows($check) < 1){
    endCode("Essa imagem não existe.", false);
}

$img = 
$caminho = "../../../../imagens/galeria";

if(unlink("$caminho/$img")){
    mysqli_query($__CONEXAO__, "delete from imagensgp where id='$id'");
    endCode("Imagem excluida", true);
} else {
    endCode("Erro ao excluir imagem / $caminho/$img", false);
};
