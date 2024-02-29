<?php
include"auth.php";
date_default_timezone_set('America/Sao_Paulo');
header('Content-Type: text/html; charset=utf-8');

session_start();
$__CONEXAO__ = mysqli_connect(
    LOG_DB_LOCAL,
    LOG_DB_USER,
    LOG_DB_PASSWORD,
    LOG_DB_USER
) or die ("Atualize a página e tente novamente!");

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');


// USER 

$__EMAIL__ = $_SESSION["email"];
$__PASSWORD__ = $_SESSION["password"];

$_query_ = mysqli_query($__CONEXAO__, "select * from users where email='$__EMAIL__' and senha='$__PASSWORD__'");

if(mysqli_num_rows($_query_) < 1){
    session_destroy();
    session_start();

    $__EMAIL__ = $_SESSION["email"];
    $__PASSWORD__ = $_SESSION["password"];
} else {
    $__ASSOC__ = mysqli_fetch_assoc($_query_);
    $__ID__ = $__ASSOC__['id'];
    $__TYPE__ = $__ASSOC__['typeC'];
    $__ACTIVE__ = $__ASSOC__['active'];
    $__EMAIL__  = $__ASSOC__['email'];

    if($__ACTIVE__ == "0"){
        endCode("Sua conta está inativa, peça para um administrador reativar", false);
    };
}


// SERVER
$__METHOD__ = $_SERVER["REQUEST_METHOD"];
$__STATUS__ = $_SERVER["REDIRECT_STATUS"];
$__URL__ = $_SERVER["HTTP_HOST"];

$__WEB__ = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];

$__TIME__ = time();

$__YEAR__ = date("Y");

$__CODE__ = bin2hex(random_bytes(3));

// EMAIL 

$__HEADERS__[] = 'MIME-Version: 1.0';
$__HEADERS__[] = 'Content-type: text/html; charset=iso-8859-1';
$__HEADERS__[] = "From: Voleibol <contato_$__CODE__@$__URL__>";
$__HEADERS__[] = "Reply-to: no-reply";
$__HEADERS__[] = 'X-Mailer: PHP/' . phpversion();

// FUNÇÕES

function endCode($msg, $status){
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array("mensagem"=>$msg, "response"=>$status));
    exit;
}

function urlAmigavel($string) {
    $string = mb_strtolower($string, 'UTF-8');
    $string = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
    $string = preg_replace('/-+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

function setNoXss($string) {
    $string = preg_replace('/[^A-Za-zÀ-ÿ0-9\s,\-#]+/', ' ', $string);
    $string = strtolower($string);
    return encrypt($string);
}


function setString($string){
    $string = preg_replace('/[^A-Za-zÀ-ÿ]+/', ' ', $string);
    $string = strtolower($string);
    return encrypt($string);
}


function setEmail($string){
    $string = filter_var($string, FILTER_VALIDATE_EMAIL);
    $string = strtolower($string);
    return encrypt($string);
}

function setNum($string){
    $string = preg_replace('/[^0-9]+/', '', $string);
    return encrypt($string);
}

function checkMissing($array){
    for($i = 0; $i < count($array); $i++){
        $item = decrypt($array[$i]);
        if(!$item or $item == "" or $item == " "){
            endCode("Algum dado está faltando. #$i", false);
        }
    }
}


function cantLog($__EMAIL__){
    if($__EMAIL__){
        header("Location: $__URL__");
        exit;
    }
}

function justLog($__EMAIL__, $__TYPE__, $type){
    if($__TYPE__ < $type or !$__EMAIL__){
        endCode("Sem permissão", false);
        exit;
    }
}


function requireLevel($__TYPE__, $type){
    if($__TYPE__ < $type or !$__TYPE__){
        return false;
    }
    return true;
}

function scapeString($__CONEXAO__, $string){
    $string = mysqli_real_escape_string($__CONEXAO__, $string);
    return $string;
}

function stopUserExist($__CONEXAO__, $string){
    $tryConnect = mysqli_query($__CONEXAO__, "select * from users where email='$string'") or die("erro select");

    if(mysqli_num_rows($tryConnect) > 0){
        endCode("Email já está em uso", false);
        exit;
    }
}

function stopUserExistnt($__CONEXAO__, $string){
    $tryConnect = mysqli_query($__CONEXAO__, "select * from users where email='$string'") or die("erro select");

    if(mysqli_num_rows($tryConnect) < 1){
        return true;
    }
}

function setCpf($cpf) {
    $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

    if (strlen($cpf) != 11) {
        return false;
    }

    if (preg_match('/(\d)\1{10}/', $cpf)) {
        endCode("O cpf informado está incorreto.", false);
    }

    for ($t = 9; $t < 11; $t++) {
        for ($d = 0, $c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            endCode("O cpf informado está incorreto.", false);
        }
    }
    return encrypt($cpf);
}

function converterHora($time){
    $time = decrypt($time);
    $time = date("H:i", ($time / 1000 + 10800 ));//10800 = +3h timezone
    return $time;
}
// types user
// type 1 - Aluno
// type 2 - Professor
// type 3 - Admin
