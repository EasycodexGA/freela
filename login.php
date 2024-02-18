<?php 
include 'sys/conexao.php';
cantLog($__EMAIL__);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Volêi - Login</title>
    <link rel="stylesheet" href="style/login.css">
    <link rel="stylesheet" href="style/root.css">

</head>
<body>
    <div id="outBox">
        <div class="logo">
            <div class="img-div">
                <img src="img/prefeitura.jpg">
            </div>
            <p class="title-p1">Voleibol</p>
            <p class="title-p2">Escolinhas</p>
        </div>
        <div id="loginBox">
            <div class="inputDiv">
                <p class="spanlog">Email</p>
                <input name="email" id="email">
            </div>
            <div class="inputDiv">
                <p class="spanlog">Senha</p>
                <input type="password" name="password" id="password">
            </div>
            <div class="loginBot">
                <button id="sendData">Enviar</button>
                <button id="forgotPass">Esqueceu sua senha?</button>
            </div>
        </div>
    </div>

    <script>
        sendData.addEventListener('click', ()=>{
            let data = {email: email.value, password: password.value}
            fetch('./sys/api/loginApi',{
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(e=>e.json())
            .then(e=>{
                console.log(e)
                if(e.response){
                    window.location.href="../";
                }
            })
        })
        forgotPass.addEventListener('click', ()=>{
            let data = {email: email.value}
            fetch('./sys/api/forgotPass',{
                method: "POST",
                body: JSON.stringify(data)
            })
            .then(e=>e.json())
            .then(e=>{
                console.log(e)
                if(e.response){
                    window.location.href="../";
                }
            })
        })
    </script>

</body>
</html>