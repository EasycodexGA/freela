<?php 
include 'sys/conexao.php';
if($__TYPE__){
    header("Location: ./painel");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/root.css">
    <link rel="shortcut icon" href="img/prefeitura.png" type="image/x-icon">
    <title>Voleibol escolinhas - Login</title>
</head>
<body>
    <div id="outBox">
        <div class="logo">
            <div class="img-div">
                <img src="img/prefeitura.png">
            </div>
            <p class="title-p1">Voleibol</p>
            <p class="title-p2">Escolinhas</p>
        </div>
        
        <form action='javascript:void(0)' id="loginBox" class="login-box">
            <div class="inputDiv">
                <p id="responseFalse"></p>
                <p class="spanlog">Email</p>
                <input name="email" id="email">
            </div>
            <div class="inputDiv">
                <p class="spanlog">Senha</p>
                <input type="password" name="password" id="password">
            </div>
            <div class="loginBot">
                <button id="sendData" class="send-bt">Enviar</button>
                <button id="forgotPass" class="sub-bt">Esqueceu sua senha?</button>
            </div>
        </form>

        <form action="javascript:void(0)" id="verifyDiv" class="login-box">
            <div class="inputDiv">
                <p id="responseFalseVerify"></p>
                <p class="spanLog" id="responseVerify">Código de verificação</p>
                <input id="verifyCode" name="verifyCode">
            </div>
            <div class="inputDiv">
                <p class="spanLog">Nova senha</p>
                <input id="newPass" name="newPass" type="password">
            </div>
            <div class="loginBot">
                <button id="sendNewPass" class="send-bt">Enviar</button>
                <button id="backLogin" class="sub-bt">Voltar</button>
            </div>
        </form>
    </div>

    <script>
        sendData.addEventListener('click', ()=>{
            let data = {email: email.value, password: password.value}
            fetch('./sys/api/usuarios/loginApi',{
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(e=>e.json())
            .then(e=>{
                console.log(e)
                if(e.response){
                    window.location.href="../";
                } else {
                    responseFalse.innerHTML = e.mensagem;
                }
            })
        })

        sendNewPass.addEventListener('click', ()=>{
            let data = {email: email.value, code: verifyCode.value, password: newPass.value}
            fetch('./sys/api/usuarios/verifyCode',{
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(e=>e.json())
            .then(e=>{
                console.log(e)
                if(e.response){
                    window.location.href="../";
                } else {
                    responseFalseVerify.innerHTML = e.mensagem;
                }
            })
        })

        forgotPass.addEventListener('click', ()=>{
            let data = {email: email.value}
            fetch('./sys/api/usuarios/forgotPass',{
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(e=>e.json())
            .then(e=>{
                console.log(e)
                if(e.response){
                    responseFalseVerify.innerHTML = e.mensagem.text;
                    verifyDiv.style.display = 'flex';
                    loginBox.style.display = 'none';
                }
            })
        })

        backLogin.addEventListener('click', ()=>{
            responseFalse.innerHTML = '';
            responseFalseVerify.innerHTML = '';
            verifyDiv.style.display = 'none';
            loginBox.style.display = 'flex';
        })

        localStorage.leave = "false";
    </script>
    <script src="https://whos.amung.us/pingjs/?k=partiuvolei&t=Partiu Vôlei - Login&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>
    <script src="https://whos.amung.us/pingjs/?k=totalmoontis&t=Partiu Vôlei - Login&c=d&x=https://partiuvolei.com/&y=&a=0&v=27&r=5847"></script>

</body>
</html>