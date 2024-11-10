<?php
session_start();
$nome = $_SESSION['user_log'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de usuário</title>
    <link rel = "stylesheet" href = "../styles/styleConfcad.css">
</head>
<body>
    <header>
    </header>

    <main>
        <div class="container">
            <div class="popup" id="popup">
                <img src="../_imagens/sistema/confirm_icon.png">
                <h2>Cadastro realizado com sucesso!</h2>
                <p>Olá, <?php echo "$nome";?>. Obrigado por criar uma conta na Tô Com Fome! Desejamos um bom apetite!</p>
                <p>Você será automaticamente logado na sua conta após alguns segundos.</p><br>
            </div>
        </div>
    </main>
<script>

let popup = document.getElementById("popup");

window.onload = function() {
    popup.classList.add("open-popup");
}

setTimeout(function() {
    window.location.href = "../index.php";
}, 5000);


</script>
</body>
</html>