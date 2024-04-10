<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

if(!uniqueLevel($__TYPE__, 2)){
    endCode("Você não pode alterar o currículo.", false);
    exit;
}

$request = file_get_contents('php://input');
$json = json_decode($request);

$what  = scapeString($__CONEXAO__, $json->what);
$what  = setNoXss($what);

checkMissing(array(
    $what
));

$what = decrypt($what);

if($what != "curriculo" and $what != "imagem"){
    endCode("Inválido.", false);
}

mysqli_query($__CONEXAO__, "update users set $what='' where email='$__EMAIL__'");

endCode("Removido com sucesso!", true);

