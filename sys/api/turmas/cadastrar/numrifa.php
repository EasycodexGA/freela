<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$ref        = scapeString($__CONEXAO__, $json->ref);
$user       = scapeString($__CONEXAO__, $json->user);
$num        = $json->num;
$nome       = scapeString($__CONEXAO__, $json->nome);
$email      = scapeString($__CONEXAO__, $json->email);
$telefone   = scapeString($__CONEXAO__, $json->telefone);

$ref        = setNum($ref);
$user       = setNum($user);
$nome       = setString($nome);
$email      = setEmail($email);
$telefone   = setNum($telefone);

checkMissing(
    array(
        $ref,
        $user,
        $nome
    )
);

checkAllMissing(
    array(
        $email,
        $telefone
    )
)

$ref    = decrypt($ref);
$user   = decrypt($user);


$getMax = mysqli_query($__CONEXAO__, "select qt from rifas where id='$ref'");
$qt     = mysqli_fetch_assoc($getMax)['qt'];
foreach($num as &$n){
    $n = setNum($n);
    checkMissing(array($n));
    $n = decrypt($n);
    
    $getNum = mysqli_query($__CONEXAO__, "select id from numerorifa where num='$n' and ref='$ref'");
    if(mysqli_num_rows($getEvento) > 0){
        endCode("Já existe o número $n nesta rifa.", false);
    }
    if($n > $qt or $n < 1){
        endCode("Número $n inexistente na rifa.", false);
    }
}

foreach($num as $n){
    mysqli_query($__CONEXAO__, "insert into numerorifa (ref, user, numero, nome, email, telefone, status) values ('$ref', '$user', '$n', '$nome', '$email', '$telefone', 'pending')");
}


endCode("Sala criada com sucesso", true);