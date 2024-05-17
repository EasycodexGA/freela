<?php
include '../../../conexao.php';

justLog($__EMAIL__, $__TYPE__, 3);

header('Content-Type: application/json; charset=utf-8');

$request = file_get_contents('php://input');
$json = json_decode($request);

$nomeresp1  = scapeString($__CONEXAO__, $json->nomeresp1);
$nomeresp2  = scapeString($__CONEXAO__, $json->nomeresp2);
$telresp1  = scapeString($__CONEXAO__, $json->telresp1);
$telresp2  = scapeString($__CONEXAO__, $json->telresp2);
$mailresp1  = scapeString($__CONEXAO__, $json->mailresp1);
$mailresp2  = scapeString($__CONEXAO__, $json->mailresp2);
$imageresp1  = scapeString($__CONEXAO__, $json->imageresp1);
$imageresp2  = scapeString($__CONEXAO__, $json->imageresp2);

$nomeresp1 = setNoXss($nomeresp1);
$nomeresp2 = setNoXss($nomeresp2);
$telresp1 = setNoXss($telresp1);
$telresp2 = setNoXss($telresp2);
$mailresp1 = setEmail($mailresp1);
$mailresp2 = setEmail($mailresp2);

checkMissing(
    array(
        $nomeresp1,
        $nomeresp2,
        $telresp1,
        $telresp2,
        $mailresp1,
        $mailresp2,
    )
);

function salvarImg($__CONEXAO__, $__TIME__, $__CODE__, $image, $local){
    $caminho = "../../../../imagens/responsaveis";

    if($image){

        if (!file_exists($caminho)) {
            if (!mkdir($caminho, 0777, true)) {
                endCode("Erro ao criar o diretório", false);
                return;
            }
        }

        $parts = explode(',', $image);
        if (count($parts) !== 2) {
            endCode("Código de imagem inválido", false);
            return;
        }

        $formatPart = $parts[0];
        $imageData = base64_decode($parts[1]);

        if ($imageData === false) {
            endCode("Decodificação de base64 falhou", false);
            return;
        }

        $format = str_replace(['data:image/', ';base64'], '', $formatPart);
        if (!in_array($format, ['jpeg', 'jpg', 'gif', 'png'])) {
            endCode("Formato de imagem inválido", false);
            return;
        }

        if ($format === 'jpeg') {
            $format = 'jpg';
        }

        $novoNome   = "l$__TIME__$__CODE__.$format";
        $completo = "$caminho/$novoNome";
        $novoNomeEnc = encrypt($novoNome);

        // Verifique se a imagem é PNG e processe-a de acordo
        if ($format === 'png') {
            $im = imagecreatefromstring($imageData);
            imagesavealpha($im, true);
            imagepng($im, $completo);
            imagedestroy($im);
        } else {
            if (!file_put_contents($completo, $imageData)) {
                endCode("Erro ao salvar imagem", false);
            }
        }
    }
    $rmimg = mysqli_query($__CONEXAO__, "select $local from configs where id='1'");
    $assRmimg = mysqli_fetch_assoc($rmimg);
    $oldimg = decrypt($assRmimg[$local]);
    unlink("$caminho/$oldimg");

    if(!$image){
        mysqli_query($__CONEXAO__, "update configs set $local=''") or endCode("Erro ao salvar", false);
    }

    if (file_exists($completo)) {
        mysqli_query($__CONEXAO__, "update configs set $local='$novoNomeEnc'") or endCode("Erro ao salvar", false);
    }
}

salvarImg($__CONEXAO__, $__TIME__, $__CODE__, $imageresp1, "resp1foto");
sleep(5);
salvarImg($__CONEXAO__, $__TIME__, $__CODE__, $imageresp2, "resp2foto");

$restoData1 = array(
    "nome"=>$nomeresp1,
    "telefone"=>$telresp1,
    "email"=>$mailresp1
);

$restoData2 = array(
    "nome"=>$nomeresp2,
    "telefone"=>$telresp2,
    "email"=>$mailresp2
);

$restoData1 = encrypt(json_encode($restoData1));
$restoData2 = encrypt(json_encode($restoData2));

mysqli_query($__CONEXAO__, "update configs set resp1data='$restoData1', resp2data='$restoData2'") or endCode("Erro ao salvar", false);

endCode("Sucesso!", true);
?>
