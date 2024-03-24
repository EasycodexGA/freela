<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=relatorio_aluno.csv');

$resultado = fopen("php://output", 'w');

$cabecalho = ['id', 'Nome', 'E-mail','CPF','Nascimento', mb_convert_encoding('Endereço', 'ISO-8859-1', 'UTF-8')];

fputcsv($resultado, $cabecalho, ';');

$query = mysqli_query($__CONEXAO__, "select id, nome, email, cpf, nascimento from alunos where typeC='1'");

while($dados = mysqli_fetch_array($query)){
    fputcsv($resultado, $dados, ';');
}
