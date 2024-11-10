<?php
//-- Funções Legais
include '_php/is_email.php';
include '_php/crypto.php';
session_start(); // Inicia a sessão

# Dados de conexão
$host = "localhost";
$username = "ialuana_tocomfome_root";
$password = "<Ma3t3mcaf3?>";

# Nome do bd
$dbase = "ialuana_tocomfome";


try {
    $nome = $_POST['user_name'];
    $pass = $_POST['password'];
    $nomecad = '';
    if ($nome != '' && $pass != ''){
        $conn = new PDO("mysql:host=$host;dbname=$dbase", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(is_email($nome)){
            $a = new Crypto();
            $nome = $a->cript($nome);
        }

        $data = $conn->prepare('SELECT * FROM usuario WHERE nome = :nome OR email = :nome');
        $data->execute(array('nome' => $nome));
        $result = $data->fetchAll();
        if ( count($result) ) {
            foreach($result as $row) {
                $userid = $row[0];
                $nomecad = $row[1];
                $active = $row[2];
                $emailcad = $row[3];
                $passcad = $row[4];
                $user_img = $row[5];
                $user_adm = $row[6];
            }

        }
    
        $s = '<bds3md4d0s!?>';
        $a = new Crypto();
        $senha = $a->decript($passcad, $s);
        $email = $a->decript($emailcad, $s);
        if ($nomecad == $nome && $pass == $senha && $active == 1 || $emailcad == $nome && $pass == $senha && $active == 1) {
            //$data2 = $conn->prepare('SELECT * FROM mebr_privilege WHERE user_id = :userid');
            //$data2->execute(array('userid' => $userid));
            //$result2 = $data2->fetchAll();
            //if ( count($result2) ) {
            //    $membro = true;
            //}else {
                $membro = false;
            //}
            if (!file_exists("_imagens/users/$user_img")){
                $user_img = 'LUNARIS.png';
            }
            if ($nomecad == $nome){
                $_SESSION['user_id'] = $userid;
                $_SESSION['user_log'] = $nome;
                $_SESSION['user_pass'] = $pass;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_mebr'] = $membro;
                $_SESSION['user_img'] = $user_img;
                $_SESSION['user_adm'] = $user_adm;
                header("Location: index.php");
                echo '<script charset="utf-8">alert("Login realizado com sucesso!!!.")</script>';
                exit();
            }else {
                $a = new Crypto();
                $nome = $a->decript($nome, $s);
                $_SESSION['user_id'] = $userid;
                $_SESSION['user_log'] = $nomecad;
                $_SESSION['user_pass'] = $pass;
                $_SESSION['user_email'] = $nome;
                $_SESSION['user_mebr'] = $membro;
                $_SESSION['user_img'] = $user_img;
                $_SESSION['user_adm'] = $user_adm;
                header("Location: index.php");
                echo '<script charset="utf-8">alert("Login realizado com sucesso!!!.")</script>';
                exit();
            }
        }
        else{
            if ($nomecad != $nome && $emailcad != $nome){
                echo '<script charset="utf-8">alert("Nome de usuário incorreto.")</script>';
            }else if ($pass != $senha){
                echo '<script charset="utf-8">alert("Senha incorreta.")</script>';
            }else if ($active == 0){
                echo '<script charset="utf-8">alert("Nome de usuário incorreto.")</script>';
            }
        }
        unset($data);
    }
}catch(PDOException $e) {
    $z='';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tô Com Fome - Entrar</title>
    <link rel="stylesheet" href="styles/logonStyle.css">
    <link rel="shortcut icon" href="_imagens/sistema/logo.png" type="image/x-icon">
</head>
<body id = "validation">
    <main>
        <div class = "form">
            <h2>Entrar na sua conta.</h2>
            <br><p>
                Bem-vindo de volta à Tô Com Fome! Para continuar, faça o login na sua conta no nosso site.
            </p><br><br><br>
            <form id="normal" action="login" method="post" enctype="multipart/form-data">
                <div>
                    <label for = "nome"><ion-icon name="person-outline"></ion-icon> Usuário<div id="obri">*</div>: </label>
                    <input type = "text" class = "campo" id = "nome" name = "user_name" required autofocus maxlength="30" placeholder = "Nome ou E-mail"> <br>
                </div>
                <div>
                    <label for = "senha"><ion-icon name="lock-closed-outline"></ion-icon> Senha<div id="obri">*</div>: </label>
                    <input type = "password" class = "campo" id = "senha" name = "password" required minlength="8" maxlength="20" placeholder = "8-20 Caracteres"> <br>
                </div><br>
                <div class="notf">Notificador</div><br>
                <input id='logar' type="submit" value="Login" class="button" name="enviar">
                <br><br><div id="obri">*</div></label>Campo obrigatório.<br><br>
                <div>
                    <p>Eu não possuo uma conta <a href = "cadastro.php">Cadastrar</a></p>
                </div>
            </form>
            </div>
    </main>
    <footer></footer>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script>
    
        const nome = document.querySelector("#nome")
        const senha = document.querySelector("#senha")
        const notf = document.querySelector('.notf')
        const btnLogar = document.querySelector('#logar')

        btnLogar.addEventListener('click', function(e){
            notf.innerText = ''
            notf.style.opacity = "0%";
            notf.style.display = 'block';
            if (nome.value == '' || senha.value == '') {
                notf.innerText = 'Preencha todos os campos.'
                notf.style.opacity = "100%"
            }
        })
    </script>
</body>
</html>