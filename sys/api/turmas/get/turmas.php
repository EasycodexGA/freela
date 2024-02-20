<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 0);

$complemento = '';

$_query_ = mysqli_query($__CONEXAO__, "select * from turmas");

if($__TYPE__ < 2){
    $table = 'alunos';
    if($__TYPE__ == 1){
        $table = 'professores';
    }
    echo 'Table: ' . $table;
    $query = mysqli_query($__CONEXAO__, "select * from $table where email='$__EMAIL__'");
    $turmas = '';
    while($getQuery = mysqli_fetch_array($query)){
        $value = $getQuery['turma'];
        echo ' Value: ' . $value;
        $valuedec = decrypt($value);
        echo ' Valuedec: ' . $valuedec;
        $turmas .= $valuedec . ' , ';
    }
    $turmas = substr($turmas, 0, -3);
    echo ' Turmas: ' . $turmas;
    $complemento = 'where id in ($turmas) order by field(id, $turmas)';
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas $complemento");
}

$array = array();

while($dados = mysqli_fetch_array($_query_)){
    $nome = decrypt($dados["nome"]);
    echo ' Nome: ' . $nome;
    $categoria = decrypt($dados["categoria"]);

    $status = $dados["active"];

    $status = $status == '1' ? "active" : "inactive";

    $idC = encrypt($dados["id"]);

    $query = mysqli_query($__CONEXAO__, "select id from alunos where turma='$idC'");
    
    $arr = array(
        "id"            => $dados["id"], 
        "nome"          => $nome, 
        "categoria"     => $categoria,
        "alunos"        => mysqli_num_rows($query),
        "profissionais" => 0,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);