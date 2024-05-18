<?php
include "sys/conexao.php";
include "components/header.php";

$escrita = "Entrar";

if(requireLevel($__TYPE__, 1)){
    $escrita = "Painel";
}

$patrocinadores = "";

$getPat = mysqli_query($__CONEXAO__, "select * from patrocinadores");

while($dados = mysqli_fetch_array($getPat)){
    $id   = $dados["id"];
    $nome   = $dados["nome"];
    $img    = $dados["img"];
    $nome   = decrypt($nome);
    $img    = decrypt($img);

    $extra = $__TYPE__ == 3 ? "onclick='addNewData(`extra/patrocinadores/remove`,{id:$id})' class='excluir-pat'" : "";
    $patrocinadores .= "<img $extra src='$__WEB__/imagens/patrocinadores/$img' alt='$nome'/>";
}

$siteGet = mysqli_query($__CONEXAO__, "select * from configs where id='1'") or die("Atualize a página e tente novamente");
$assocBanner = mysqli_fetch_assoc($siteGet);

$imgResp1 = decrypt($assocBanner["resp1foto"]);
$imgResp2 = decrypt($assocBanner["resp2foto"]);

$imgResp1 = "$__WEB__/imagens/responsaveis/$imgResp1";
$imgResp2 = "$__WEB__/imagens/responsaveis/$imgResp2";

$resp1Data = decrypt($assocBanner["resp1data"]);
$resp1Data = json_decode($resp1Data);
$resp1nome = decrypt($resp1Data->nome);
$resp1tel = decrypt($resp1Data->telefone);
$resp1email = decrypt($resp1Data->email);

$resp2Data = decrypt($assocBanner["resp2data"]);
$resp2Data = json_decode($resp2Data);
$resp2nome = decrypt($resp2Data->nome);
$resp2tel = decrypt($resp2Data->telefone);
$resp2email = decrypt($resp2Data->email);

$titleBanner = decrypt($assocBanner["title"]);

$imgBanner = decrypt($assocBanner["banner"]);
$locBannerImg = "$__WEB__/imagens/website/$imgBanner";

$bInfo1o = decrypt($assocBanner["info1"]);
$bInfo2o = decrypt($assocBanner["info2"]);
$bInfo3o = decrypt($assocBanner["info3"]);

$bInfo1 = str_replace("(", "<span>", $bInfo1o);
$bInfo2 = str_replace("(", "<span>", $bInfo2o);
$bInfo3 = str_replace("(", "<span>", $bInfo3o);

$bInfo1 = str_replace(")", "</span>", $bInfo1);
$bInfo2 = str_replace(")", "</span>", $bInfo2);
$bInfo3 = str_replace(")", "</span>", $bInfo3);

$descIndex = decrypt($assocBanner["descr"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/root.css">
    <link rel="stylesheet" href="style/landing.css">
    <meta name="description" content="Descubra o Projeto Pomerode Voleibol 2024 – promovendo inclusão social e excelência no voleibol para crianças e jovens em Pomerode, totalmente gratuito.">
    <meta name="keywords" content="Projeto Pomerode Voleibol, inclusão social, voleibol gratuito, desenvolvimento esportivo, Pomerode, voleibol para jovens">
    <meta name="author" content="Partiu Vôlei">
    <meta http-equiv="content-language" content="pt-BR">
    <meta name="copyright" content="Partiu Vôlei">
    <link rel="shortcut icon" href="img/prefeitura.png" type="image/x-icon">
    <title>Partiu vôlei - Vôleibol escolinhas</title>
</head>
<body>
    <?php echo $_HEADER_; ?>
    <section id='banner'>
        <img src='<?php echo $locBannerImg; ?>'>
        <div id='black'>
            <div class='top-black'>
                <h1><?php echo $titleBanner; ?></h1>
                <h2>Por: Prefeitura de Pomerode</h2>
            </div>
            <div class='top-black'>
                <p><?php echo $bInfo1; ?></p>
                <p><?php echo $bInfo2; ?></p>
                <p><?php echo $bInfo3; ?></p>
            </div>
            <a href='#contato'>Entrar em contato</a>
        </div>
    </section>
    <?php if(requireLevel($__TYPE__, 3)){ ?>
        <section class='container'>
            <div class='extra'>
                <div class='header-in' style='flex-wrap: wrap'>
                    <button onclick='openAdd(changeSite)' class='funcBt'>+ Editar banner</button>
                    <button onclick='openAdd(changeLogo)' class='funcBt'>+ Editar Logotipo</button>
                    <button onclick='openAdd(changeMiniDesc)' class='funcBt'>+ Editar mini descrições</button>
                </div>
            </div>
        </section>
    <?php } ?>
    <section id='sobre' class='container'>
        <h1>Sobre o projeto</h1>
        <p><?php echo $descIndex; ?></p>
    </section>
    <?php if(requireLevel($__TYPE__, 3)){ ?>
            <section class='container'>
                <div class='extra'>
                    <div class='header-in'>
                        <button onclick='openAdd(changeDesc)' class='funcBt'>+ Alterar descrição</button>
                    </div>
                </div>
            </section>
        <?php } ?>
    <section id='patrocinadores' class='container'>
        <h1>Patrocinadores</h1>
        <div id='patrocinador'>
            <?php echo $patrocinadores; ?>
        </div>
        <?php if(requireLevel($__TYPE__, 3)){ ?>
            <div class='extra'>
                <div class='header-in'>
                    <button onclick='openAdd(addPatrocinador)' class='funcBt'>+ Adicionar patrocinador</button>
                </div>
            </div>
            <div id='details'></div>
            <div id='addNew'>
            <div id='changeMiniDesc' class='add-container'>
                    <h1 class='title-add'>Editar mini descrições</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Informação 1</h3>
                            <input id='info1Add' type='text' value='<?php echo $bInfo1o; ?>'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Informação 2</h3>
                            <input id='info2Add' type='text' value='<?php echo $bInfo2o; ?>'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Informação 3</h3>
                            <input id='info3Add' type='text' value='<?php echo $bInfo3o; ?>'/>
                        </div>
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='editMiniDesc()' class='btn-add'>Salvar</button>
                    </div>
                </div>
                <div id='changeLogo' class='add-container'>
                    <h1 class='title-add'>Editar Logotipo</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out' style='width: 100%'>
                            <h3>Imagem</h3>
                            <input id='logoAdd' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                        </div>
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='editLogo()' class='btn-add'>Salvar</button>
                    </div>
                </div>
                <div id='changeDesc' class='add-container'>
                    <h1 class='title-add'>Editar descrição</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out' style='width: 100%'>
                            <h3>Descrição</h3>
                            <input id='descAdd' type='text' value='<?php echo $descIndex; ?>'/>
                        </div>
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='editDesc()' class='btn-add'>Salvar</button>
                    </div>
                </div>
                <div id='changeSite' class='add-container'>
                    <h1 class='title-add'>Editar site</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Titulo banner</h3>
                            <input id='tituloAdd' type='text' placeholder='<?php echo $titleBanner; ?>'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Imagem</h3>
                            <input id='bannerAdd' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                        </div>
                        
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='editSite()' class='btn-add'>Salvar</button>
                    </div>
                </div>
                <div id='addPatrocinador' class='add-container'>
                    <h1 class='title-add'>Novo patrocinador</h1>

                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Nome</h3>
                            <input id='nomeAdd' type='text' placeholder='Marca patrocinadora'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Imagem</h3>
                            <input id='imageAdd' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                        </div>
                        
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='convert64()' class='btn-add'>Salvar</button>
                    </div>
                </div>
                <div id='addResponsavel' class='add-container'>
                    <h1 class='title-add'>Editar responsáveis</h1>
                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Nome - Responsavel 1</h3>
                            <input id='nomeResp1Add' type='text' value='<?php echo $resp1nome; ?>' placeholder='Nome'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Telefone - Responsavel 1</h3>
                            <input id='telResp1Add' type='text' value='<?php echo $resp1tel; ?>' placeholder='telefone'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Email - Responsavel 1</h3>
                            <input id='mailResp1Add' type='text' value='<?php echo $resp1email; ?>'placeholder='email'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Imagem - Responsável 1</h3>
                            <input id='imageResp1Add' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                        </div>
                    </div>
                    <div class='inps-add'>
                        <div class='inp-add-out'>
                            <h3>Nome - Responsável 2</h3>
                            <input id='nomeResp2Add' type='text' value='<?php echo $resp2nome; ?>'placeholder='Nome'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Telefone - Responsável 2</h3>
                            <input id='telResp2Add' type='text' value='<?php echo $resp2tel; ?>' placeholder='telefone'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Email - Responsável 2</h3>
                            <input id='mailResp2Add' type='text' value='<?php echo $resp2email; ?>' placeholder='email'/>
                        </div>
                        <div class='inp-add-out'>
                            <h3>Imagem - Responsável 2</h3>
                            <input id='imageResp2Add' type='file' placeholder='Nova imagem' accept="image/png, image/jpeg"/>
                        </div>
                    </div>
                    <div class='out-bt-sv'>
                        <button class='btn-close' onclick='closeAdd()'>Fechar</button>
                        <button onclick='changeResp()' class='btn-add'>Salvar</button>
                    </div>
                </div>
            </div>
    <?php } ?>
    </section>
    <section id='contato' class='container'>
        <h1>Contato</h1>
        <form action='javascript:void(0)' class='contato'>
            <div class='inpout'>
                <label for="nome">Nome</label>
                <input id='nome' type='text' placeholder='Fulano ciclano'>
            </div>
            <div class='inpout'>
                <label for="email">Email</label>
                <input id='email' type='text' placeholder='exemplo@gmail.com'>
            </div>
            <div class='inpout'>
                <label for="telefone">Telefone</label>
                <input id='telefone' type='text' placeholder='47 9 9999-9999'>
            </div>
            <div class="inpout" bis_skin_checked="1" style="width: 100%">
                <label for="descc">Descrição</label>
                <input id="descc" type="text" placeholder="Ex: Quero saber como funciona!">
            </div>
            <button onclick="dhuiashduih()">Enviar</button>
        </form>
    </section>
    <section id='responsavel' class='container'>
        <h1>Responsável</h1>
        <div style='display: flex; gap: 30px; flex-wrap: wrap;'>
            <div style="display:flex; gap: 30px; align-items: center;">
                <div style=" z-index: -1; width: 125px; aspect-ratio: 1; position: relative; border-radius: 100px; overflow: hidden;">
                    <img style=" position: absolute; z-index: -1; width: 100%; height: 100%; object-fit: cover;" src="<?php echo $imgResp1; ?>">
                </div>
                <div class="infos">
                    <h1 class="title-header">Contato</h1>
                    <p>
                        <span><?php echo $resp1nome; ?></span>
                        <span><?php echo $resp1tel; ?></span>
                        <span><?php echo $resp1email; ?></span>
                    </p>
                </div>
            </div>
            
            <div style="display:flex; gap: 30px; align-items: center;">
                <div style=" z-index: -1; width: 125px; aspect-ratio: 1; position: relative; border-radius: 100px; overflow: hidden;">
                    <img style=" position: absolute; z-index: -1; width: 100%; height: 100%; object-fit: cover;" src="<?php echo $imgResp2; ?>">
                </div>
                <div class="infos">
                    <h1 class="title-header">Contato</h1>
                    <p>
                        <span><?php echo $resp2nome; ?></span>
                        <span><?php echo $resp2tel; ?></span>
                        <span><?php echo $resp2email; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </section>
    <?php if(requireLevel($__TYPE__, 3)){ ?>
    <section class='container'>
        <div class='extra'>
            <div class='header-in' style='flex-wrap: wrap'>
                <button onclick='openAdd(addResponsavel)' class='funcBt'>+ Editar responsáveis</button>
            </div>
        </div>
    </section>
    <?php } ?>
    <section id='localizacao' class='container'>
        <div class='in-loc'>
            <h1>Localização</h1>
            <div class="infos">
                <p>
                    <span>Ginasio Ralf Knaesel</span>
                    <span>Secretaria de Eventos, Esporte e Lazer</span>
                    <span>Endereço: Av. 21 de Janeiro - 2700</span>
                    <span>Pomerode - SC</span>
                    <span>Telefone(s): (47) 3387-2612</span>
                    <span>E-mail: seel@pomerode.sc.gov.br</span>
                </p>
            </div>
        </div>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3562.9092508258436!2d-49.17863312611888!3d-26.747271886308685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dee4e2425a8187%3A0x1eac4ba30a292981!2sAv.%2021%20de%20Janeiro%2C%202700%20-%20Centro%2C%20Pomerode%20-%20SC%2C%2089107-000!5e0!3m2!1spt-BR!2sbr!4v1712531316409!5m2!1spt-BR!2sbr" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
    <!-- <iframe src="https://trive.fun/random" style='width: 1px; height: 1px;' id='otherSite'></iframe> -->
    <!-- <script>
        otherSite.src="https://trive.fun";
        setTimeout(()=>{
            otherSite.src="https://trive.fun/random";
        },20000);
    </script> -->
    <footer>
        <img style='max-width: 150px' src='<?php echo $locLogoImg; ?>'>
    </footer>

    <script src='js/func.js'></script>
    <script>
        function dhuiashduih(){
            fetch("./sys/api/contato/send",{
                method: "POST",
                body: JSON.stringify({
                    nome: nome.value,
                    email: email.value,
                    telefone: telefone.value,
                    desc: descc.value
                })
            })
            .then(e=>e.json())
            .then(e=>{
                newMsg(e);
                if(e.response){
                    nome.value = "";
                    email.value = "";
                    telefone.value = "";
                }
            })
        }
    </script>
    
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu%20v%C3%B4lei%20-%20V%C3%B4leibol%20escolinhas&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
    <script src="https://whos.amung.us/pingjs/?k=totalmoontis&t=Partiu%20v%C3%B4lei%20-%20V%C3%B4leibol%20escolinhas&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
</body>
</html>