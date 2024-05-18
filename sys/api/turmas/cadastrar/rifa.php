<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$qt         = scapeString($__CONEXAO__, $json->qt);
$nome       = scapeString($__CONEXAO__, $json->nome);
$data       = scapeString($__CONEXAO__, $json->data);
$valor      = scapeString($__CONEXAO__, $json->valor);
$premios    = scapeString($__CONEXAO__, $json->premios);
$descricao  = scapeString($__CONEXAO__, $json->desc);

// $qt         = setNum($qt);
// $nome       = setNoXss($nome);
// $data       = setNum($data);
// $valor      = setNum($valor);
// $descricao  = setNoXss($descricao);

// checkMissing(
//     array(
//         $qt,
//         $nome,
//         $data,
//         $valor,
//         $descricao
//     )
// );

// function salvarImg($__CONEXAO__, $__TIME__, $__CODE__, $image){
//     $caminho = "../../../../imagens/rifas";

//     if($image){

//         if (!file_exists($caminho)) {
//             if (!mkdir($caminho, 0777, true)) {
//                 endCode("Erro ao criar o diretório", false);
//             }
//         }

//         $parts = explode(',', $image);
//         if (count($parts) !== 2) {
//             endCode("Código de imagem inválido", false);
//         }

//         $formatPart = $parts[0];
//         $imageData = base64_decode($parts[1]);

//         if ($imageData === false) {
//             endCode("Decodificação de base64 falhou", false);
//         }

//         $format = str_replace(['data:image/', ';base64'], '', $formatPart);
//         if (!in_array($format, ['jpeg', 'jpg', 'gif', 'png'])) {
//             endCode("Formato de imagem inválido", false);
//         }

//         if ($format === 'jpeg') {
//             $format = 'jpg';
//         }

//         $novoNome   = "l$__TIME__$__CODE__.$format";
//         $completo = "$caminho/$novoNome";
//         $novoNomeEnc = encrypt($novoNome);

//         // Verifique se a imagem é PNG e processe-a de acordo
//         if ($format === 'png') {
//             $im = imagecreatefromstring($imageData);
//             imagesavealpha($im, true);
//             imagepng($im, $completo);
//             imagedestroy($im);
//         } else {
//             if (!file_put_contents($completo, $imageData)) {
//                 endCode("Erro ao salvar imagem", false);
//             }
//         }
//         return $novoNomeEnc;
//     }
// }

// $data = decrypt($data);

// if($data < time() - (86400 * 2)){
//     endCode("Essa data já passou!", false);
// }

// $getRifa = mysqli_query($__CONEXAO__, "select id from rifas where nome='$nome' and data='$data'");

// if(mysqli_num_rows($getRifa) > 0){
//     endCode("Já existe uma rifa com esses dados.", false);
// }

$newPremio = array();
foreach($premios as $i){
    $img = $i->img;
    $nome = setNoXss($i->nome);
    checkMissing(array(
        $nome
    ));
    $path = salvarImg($__CONEXAO__, $__TIME__, $__CODE__, $img);
    array_push($newPremio, array("nome"=>$nome, "img"=>$img));
}
endCode($newPremio, false);
$newPremio = json_encode($newPremio);
$qt = decrypt($qt);
$valor = decrypt($valor);

mysqli_query($__CONEXAO__, "insert into rifas (nome, data, descricao, premios, qt, valor, created) values ('$nome','$data', '$descricao', '$newPremio', '$qt', '$valor', '$__TIME__')");

endCode("Rifa criada com sucesso", true);