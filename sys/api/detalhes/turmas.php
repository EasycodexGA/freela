<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 1);

$turma  = scapeString($__CONEXAO__, $_GET['id']);
$turma = setNum($turma);
$decTurma = decrypt($turma);

if($__TYPE__ == 3){
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma'") or die("1");
} else {
    $table = $__TYPE__ == 2 ? 'professores' : 'alunos';
    $_query_ = mysqli_query($__CONEXAO__, "select * from turmas where id='$decTurma' and id in (select turma from $table where email='$__EMAIL__')") or die("2");
}


if(mysqli_num_rows($_query_) < 1){
    endCode('Essa turma não existe ou você não está participando dela.', false);
}


$array = array();
while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $categoria  = $_dados_["categoria"];
    $horario    = $_dados_["horario"];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";

    $query = mysqli_query($__CONEXAO__, "select id, nome from users where email in (select email from alunos where turma='$decTurma') and active='1'")  or die("3");
    $query2 = mysqli_query($__CONEXAO__, "select id, nome, imagem from users where email in (select email from professores where turma='$decTurma') and active='1'") or die("4");

    $arrAlunos = array();
    $arrProf = array();

    while($dados = mysqli_fetch_array($query)){
        $idA    = $dados['id'];
        $nomeA  = decrypt($dados['nome']);
        array_push($arrAlunos, array("id"=>$idA, "nome"=>$nomeA));
    }

    while($dados2 = mysqli_fetch_array($query2)){
        $idP    = $dados2['id'];
        $nomeP  = decrypt($dados2['nome']);
        $imagem = decrypt($dados2['imagem']);
        array_push($arrProf, array("id"=>$idP, "nome"=>$nomeP, "imagem"=>$imagem));
    }

    $query3 = mysqli_query($__CONEXAO__, "select id, data, descricao from aulas where turma='$decTurma' order by data desc") or die("5");
    $aulas = array();

    while($dados3 = mysqli_fetch_array($query3)){
        $idAu = $dados3['id'];
        $dataAu = $dados3['data'];
        $descAu = $dados3['descricao'];
        $query4 = mysqli_query($__CONEXAO__, "select id, aluno, presenca from chamada where aula='$idAu'") or die("6");
        $chamadaAula = array();
        while($dados4 = mysqli_fetch_array($query4)){
            $idC = $dados4['id'];
            $idAC = $dados4['aluno'];
            $queryA = mysqli_query($__CONEXAO__, "select id, nome from users where id='$idAC'");
            $idAC = mysqli_fetch_assoc($queryA)['id'];
            $nomeAC = mysqli_fetch_assoc($queryA)['nome']; 
            $presencaC = $dados4['presenca'];
            array_push($chamadaAula, array("id"=>$idC, "nome"=>decrypt($nomeAC), "idA"=>$idAC, "checked"=>$presencaC));
        }
        array_push($aulas, array("id"=>$idAu, "data"=>$dataAu, "chamada"=>$chamadaAula, "descricao"=>decrypt($descAu)));
    }

    $query5 = mysqli_query($__CONEXAO__, "select nome from categorias where id='$categoria'");
    $nomeCat = mysqli_fetch_assoc($query5)['nome'];


    $arr = array(
        "id"                => $decTurma,
        "nome"              => $nome, 
        "categoria"         => decrypt($nomeCat),
        "horario"           => converterHora($horario),
        "def_time"          => decrypt($horario),
        "profissionais"     => $arrProf,
        "alunos"            => $arrAlunos,
        "aulas"             => $aulas,
        "status"            => $status
    );
    array_push($array, $arr);

}



endCode($array, true);