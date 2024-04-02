<?php
session_start();

$__SREQ = $_SESSION["reqflood"];
$__STIME = $_SESSION["timeflood"];

$maxTime = 10;
$maxRequest = 30;

if($__STIME){
    if($__SREQ > time() - $maxTime){
        $_SESSION["timeflood"] = time();
        $_SESSION["reqflood"]  = 0;
        return;
    }

    if($__SREQ >= $maxRequest){
        endCode("Requisições demais em pouco tempo, aguerde um pouco e tente novamente", false);
    }
    
    $_SESSION["reqflood"] = $__SREQ + 1;
    return;
}

if(!$__STIME or !$__SREQ){
    $_SESSION["timeflood"] = time();
    $_SESSION["reqflood"]  = 0;
    return;
}


