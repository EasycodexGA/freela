<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=relatorio_alunos.csv');

$resultado = fopen("php://output", 'w');

$cabecalho = ['id', 'Nome', 'E-mail','CPF','Nascimento', 'Presenças', 'Faltas', 'Status', 'Turmas'];

fputcsv($resultado, $cabecalho, ';');

$query = mysqli_query($__CONEXAO__, "select id, nome, email, cpf, active nascimento from users where typeC='1'");

// $arr = array();

while($dados = mysqli_fetch_array($query)){
    $id         = $dados["id"];
    $nome       = decrypt($dados["nome"]);
    $email      = $dados["email"];
    $cpf        = decrypt($dados["cpf"]);
    $nascimento = date('d/m/Y', (decrypt($dados["nascimento"])+ 86400));
    $status     = $dados["active"];
    $status     = $status == '1' ? "active" : "inactive";
    
    $getPeF = mysqli_query($__CONEXAO__, "select presenca from chamada where aluno='$id'");
    
    $f = 0;
    $p = 0;
    
    while($d = mysqli_fetch_array($getPeF)){
        $d["presenca"] == "1" ? $p++ : $f++;
    }
    
    $turmas = "";
    
    $getTurmas = mysqli_query($__CONEXAO__, "select nome from turmas where id in (select turma from alunos where email='$email')");
    
    while($t = mysqli_fetch_array($getTurmas)){
        $nm = decrypt($t["nome"]);
        if($turmas == ""){
             $turmas .= $nm;
        } else {
            $turmas .= ", $nm";
        }
    }
    
    $cpf = "c-$cpf";

    $content = array(
        $id,
        $nome,
        decrypt($email),
        $cpf,
        $nascimento,
        $p,
        $f,
        $status,
        $turmas
    );

    // array_push($arr, $content);
    fputcsv($resultado, $content, ';');

}

// echo "<pre>";
// var_dump($arr);
// echo "</pre>";
