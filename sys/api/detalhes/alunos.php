<?php
include '../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 2);

$aluno  = scapeString($__CONEXAO__, $_GET['id']);
$aluno = setNum($aluno);
$decAluno = decrypt($aluno);

$_query_ = mysqli_query($__CONEXAO__, "select * from users where id='$decAluno'");

$array = array();

while($_dados_ = mysqli_fetch_array($_query_)){
    $nome       = decrypt($_dados_["nome"]);
    $cpf        = decrypt($_dados_["cpf"]);
    $nascimento = decrypt($_dados_["nascimento"]);
    $email      = $_dados_["email"];
    $status     = $_dados_["active"];
    $status     = $status == '1' ? "active" : "inactive";


    $query2 = mysqli_query($__CONEXAO__,"select presenca from chamada where aluno='$decAluno' and aula in (select id from aulas where data<'$__TIME__')");

    $presencas  = 0;
    $faltas     = 0;
    
    while($dados2 = mysqli_fetch_array($query2)){
        $presenca = $dados2["presenca"];
        if($presenca == 0){
            $faltas = $faltas + 1;
        } else {
            $presencas = $presencas + 1;
        }
    }

    $query  = mysqli_query($__CONEXAO__, "select id, nome from turmas where id in (select turma from alunos where email='$email')");
    
    $arrTurmas = array();

    while($dados = mysqli_fetch_array($query)){
        $turma      = $dados['nome'];
        $turmaId    = $dados['id'];
        
        array_push($arrTurmas, array("nome"=>decrypt($turma), "id"=>$turmaId, "checked"=>1));
    }

    $allTurmas = array();
    $query3 = mysqli_query($__CONEXAO__, "select id, nome from turmas where id not in (select turma from alunos where email='$email')");

    while($dados3 = mysqli_fetch_array($query3)){
        $turma3      = $dados3['nome'];
        $turmaId3    = $dados3['id'];
        array_push($allTurmas, array("nome"=>decrypt($turma3), "id"=>$turmaId3, "checked"=>0));
    }

    $turmas = array_merge($arrTurmas, $allTurmas);
    $query4  = mysqli_query($__CONEXAO__, "select id, nome from equipes where id in (select equipe from alunos where email='0wuMczB7bEU=')");
    // $query4  = mysqli_query($__CONEXAO__, "select equipe from alunos where email='$email'");
    // endCode(mysqli_num_rows($query4), false);
    $arrEquipe = array();

    while($dados = mysqli_fetch_array($query4)){
        $equipe      = $dados['nome'];
        $equipeId    = $dados['id'];
        
        array_push($arrEquipe, array("nome"=>decrypt($equipe), "id"=>$equipeId, "checked"=>1));
    }

    $allEquipes = array();
    $query5 = mysqli_query($__CONEXAO__, "select id, nome from equipes where id not in (select equipe from alunos where email='$email')");

    while($dados5 = mysqli_fetch_array($query5)){
        $equipe2      = $dados5['nome'];
        $equipeId2    = $dados5['id'];
        array_push($allEquipes, array("nome"=>decrypt($equipe2), "id"=>$equipeId2, "checked"=>0));
    }

    $equipes = array_merge($arrEquipe, $allEquipes);

    $arr = array(
        "id"            => $decAluno,
        "nome"          => $nome, 
        "email"         => decrypt($email),
        "cpf"           => $cpf,
        "nascimento"    => $nascimento,
        "turmas"        => $turmas,
        "equipes"       => $equipes,
        "presencas"     => $presencas,
        "faltas"        => $faltas,
        "status"        => $status
    );
    array_push($array, $arr);
}

endCode($array, true);