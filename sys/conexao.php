<?php
include"auth.php";
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
    $__ID__ = mysqli_fetch_assoc($_query_)['id'];
}


// SERVER
$__METHOD__ = $_SERVER["REQUEST_METHOD"];
$__STATUS__ = $_SERVER["REDIRECT_STATUS"];
$__URL__ = $_SERVER["HTTP_HOST"];

$__MAIN_WEB__ = "https://freela.anizero.cc/";
$__WEB__ = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'];

$__TIME__ = time();

$__YEAR__ = date("Y");

// FUNÇÕES

function endCode($msg, $status){
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

function setUser($string){
    $string = trim($string);
    $string = preg_replace('/\s+/', ' ', $string);
    $string = preg_replace('/[^A-Za-z]+/', ' ', $string);
    return encrypt($string);
}


function setEmail($string){
    $string = filter_var($string, FILTER_VALIDATE_EMAIL);
    return encrypt($string);
}


function cantLog($__EMAIL__){
    if($__EMAIL__){
        header("Location: $__MAIN_WEB__");
        exit;
    }
}

function justLog($__EMAIL__){
    if(!$__EMAIL__){
        header("Location: $__MAIN_WEB__");
        exit;
    }
}

function scapeString($string){
    $string = mysqli_real_escape_string($__CONEXAO__, $string);
    return $string;
}


// types user
// type 0 - aluno
// type 1 - Professor
// type 2 - Admin
