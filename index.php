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

$siteGet = mysqli_query($__CONEXAO__, "select banner, title from configs where id='1'");
$assocBanner = mysqli_fetch_assoc($siteGet);
$titleBanner = decrypt($assocBanner["title"]);
$imgBanner = decrypt($assocBanner["banner"]);
$locBannerImg = "$__WEB__/imagens/website/$imgBanner";
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
                <p>-> Do <span>Sub 13</span> ao <span>Sub 19</span>
                <p>-> Vôlei de quadra</p>
                <p>-> Vôlei de praia</p>
            </div>
            <a href='#contato'>Entrar em contato</a>
        </div>
    </section>
    <?php if(requireLevel($__TYPE__, 3)){ ?>
        <section class='container'>
            <div class='extra'>
                <div class='header-in'>
                    <button onclick='openAdd(changeSite)' class='funcBt'>+ Editar banner</button>
                </div>
            </div>
        </section>
    <?php } ?>
    <section id='sobre' class='container'>
        <h1>Sobre o projeto</h1>
        <p>Projeto desportivo que mira, além da inclusão social, o rendimento desportivo individual e coletivo. Em sua essência, o PROJETO POMERODE VOLEIBOL 2024, visa oportunizar às crianças e jovens do município de Pomerode o contato com a modalidade VOLEIBOL de forma gratuita e em um ambiente saudável e integrado com a sociedade.</p>
    </section>
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
            <div id='details'>
            </div>
            <div id='addNew'>
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
            <button onclick="dhuiashduih()">Enviar</button>
        </form>
    </section>
    <section id='responsavel' class='container'>
        <h1>Responsável</h1>
        <div style="display:flex; gap: 30px; align-items: center;">
        <div style="width: 125px; aspect-ratio: 1; position: relative; border-radius: 100px; overflow: hidden;">
            <img style="position: absolute; width: 100%; height: 100%; object-fit: cover;" src="../img/luciano.jpg">
        </div>
        <div class="infos">
            <h1 class="title-header">Contato</h1>
            <p>
                <span>Prof. Luciano Menegaz</span>
                <span>F. (48) 99806 0667</span>
                <span>lucianor.menegaz@gmail.com</span>
            </p>
        </div>
    </div>
    </section>
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

    <footer>
        <img src='./img/logo2.png'>
    </footer>

    <script src='js/func.js'></script>
    <script>
        function dhuiashduih(){
            fetch("./sys/api/contato/send",{
                method: "POST",
                body: JSON.stringify({
                    nome: nome.value,
                    email: email.value,
                    telefone: telefone.value
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