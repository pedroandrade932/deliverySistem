<?php
include '../_php/crypto.php';
include '../_php/id_user.php';
include '../_php/crop_image.php';
session_start();

# Dados de conexão
$host = "localhost";
$username = "ialuana_tocomfome_root";
$password = "<Ma3t3mcaf3?>";

# Nome do bd
$dbase = "ialuana_tocomfome";

try {
    $nome = $_POST['user_name'];
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $imagem = $_FILES["picture"];
    $userid;
    $nomecad;
    $active;
    $emailcad;
    $passcad;
    $user_img;
    if ($nome != '' && $pass != ''){
        $conn = new PDO("mysql:host=$host;dbname=$dbase", $username, $password);
        
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $data = $conn->prepare('SELECT * FROM usuario WHERE nome = :nome');
        $data->execute(array('nome' => $nome));
        $result = $data->fetchAll();
        if ( count($result) ) {
            foreach($result as $row) {
                $nomecad = $row[1];
            }

        }

        $userid = uniqidReal();
        while (true) {
            $data = $conn->prepare('SELECT * FROM usuario WHERE iduser = :userid');
            $data->execute(array('userid' => $userid));
            $result = $data->fetchAll();
            if ( count($result) ) {
                $userid = uniqidReal();
            }else{
                break;
            }
        }
        $a = new Crypto();
        $emailcript = $a->cript($email);
        $senhacript = $a->cript($pass);

        if ($nomecad == $nome) {
            echo '<script charset="utf-8">alert("O nome de usuário já foi cadastrado por outra pessoa.")</script>';
        }else{
            if ($imagem['tmp_name']) {
                $nome_img = $nome.'-'.time().'.jpg';
                if (move_uploaded_file($imagem['tmp_name'], '_imagens/users/'.$nome_img)) {
                                        
                    $data = $conn->query("INSERT INTO usuario (iduser, nome, email, senha, foto, active, adm) VALUES ($userid, '$nome', '$emailcript', '$senhacript', '$nome_img', 0, 0)");
                    resize_crop_image(600, 600, '_imagens/users/'.$nome_img, '_imagens/users/'.$nome_img);
                    
                    $_SESSION['user_name'] = $nome;
                    $_SESSION['user_email'] = $email;
                    echo
                    '<!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Tô Com Fome - Validação de Email</title>
                        <link rel="stylesheet" href="../styles/logonStyle.css">
                        <link rel="shortcut icon" href="../_imagens/sistema/logo.png" type="image/x-icon">
                        <meta http-equiv="refresh" content="0;URL=validation" />
                    </head>
                    <body>
                    </body>';
                    header("Location: validation.php");
                    exit();
                }else {
                    echo '<script charset="utf-8">alert("Erro de upload.")</script>';
                }
            }
        }
    }
    unset($data);
}catch(PDOException $e) {
    $z='';
    echo 'ERROR: ' . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tô Com Fome - Cadastro</title>
    <link rel="stylesheet" href="../styles/logonStyle.css">
    <link rel="shortcut icon" href="../_imagens/sistema/logo.png" type="image/x-icon">
</head>
<header></header>
<body id = "validation">
    <main>
        <div class = "form">
            <h2>Criar uma conta na Tô Com Fome</h2>
            <br><p>Olá, seja bem-vindo à Tô Com Fome. Para continuar navegando e acessando nossos serviços, cadastre-se! (é rapidinho)</p><br>
            <form id="normal" action="cadastro" method="post" enctype="multipart/form-data">
                <div class="form1-ani">
                    <div>
                        <label for = "nome"><ion-icon name="person-outline"></ion-icon> Nome: </label>
                        <input type = "text" class = "campo" id = "nome" name = "user_name" required autofocus maxlength="30" placeholder = "5-30 Caracteres"> <br>
                    </div>
                                        
                    <div>
                        <label for = "email"><ion-icon name="mail-outline"></ion-icon> E-mail: </label>
                        <input type = "email" class = "campo" id = "email" name = "email" required maxlength="40" placeholder = "example@email.com"> <br>
                    </div>
                    
                    <div>
                        <label for = "senha"><ion-icon name="lock-closed-outline"></ion-icon> Senha: </label>
                        <input type = "password" class = "campo" id = "senha" name = "password" required minlength="8" maxlength="20" placeholder = "8-20 Caracteres"> <br>
                    </div>
                    
                    <div>
                        <label for = "senha_conf"><ion-icon name="lock-closed-outline"></ion-icon> Senha: </label>
                        <input type = "password" class = "campo" id = "senha_conf" required minlength="8" maxlength="20" placeholder = "Confirmar senha"> <br>
                    </div>
                    <div class="notf">Notificador</div>
                    <div>
                        <label for="remember"><input type="checkbox" id="remember"> Lembrar-me</label>
                    </div>
                    <div>
                        <input type="button" id="avante" class="button" value="Avançar">
                    </div><br>
                    <div>
                        <p>Eu já possuo uma conta <a href = "login.php">Login</a></p>
                    </div>
                </div>

                <div class="form2-ani">
                    Coloque uma foto no seu perfil.<br><br><br>
                    <label class="picture" tabIndex="0" for="picture_input">
                        <span id="imgc"></span>
                        <span class="picture_image"></span>
                    </label>
                    <input type="file" accept="image/*" id="picture_input" name="picture" required><br>
                    <br>
                    <label for="comf-terms"><input type="checkbox" id="comf-terms" required> Concordo com os <a target="_blank" href="#">Termos de uso</a> deste site.</label><br><br>
                    <input type="submit" value="Cadastrar-se" id='cad' class="button" name="enviar"> <br><br>
                </div>
            </form>
        </div>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script>
        function isEmail(field) {
            usuario = field.value.substring(0, field.value.indexOf("@"));
            dominio = field.value.substring(field.value.indexOf("@")+ 1, field.value.length);
            if ((usuario.length >=1) &&
                (dominio.length >=3) &&
                (usuario.search("@")==-1) &&
                (dominio.search("@")==-1) &&
                (usuario.search(" ")==-1) &&
                (dominio.search(" ")==-1) &&
                (dominio.search(".")!=-1) &&
                (dominio.indexOf(".") >=1)&&
                (dominio.lastIndexOf(".") < dominio.length - 1)) {
                    return true
            }
            else{
                return false
            }
        }

        const inputFile = document.querySelector("#picture_input")
        const pictureImage = document.querySelector(".picture_image")
        const pictureImageTxt = document.querySelector("#imgc")
        const form1 = document.querySelector(".form1-ani")
        const form2 = document.querySelector(".form2-ani")
        const btnAvancar = document.querySelector('#avante')
        pictureImageTxt.innerHTML = 'Selecione uma imagem.'

        const nome = document.querySelector("#nome")
        const email = document.querySelector("#email")
        const senha = document.querySelector("#senha")
        const confSenha = document.querySelector("#senha_conf")
        const notf = document.querySelector('.notf')

        btnAvancar.addEventListener('click', function(e){
            notf.innerText = ''
            notf.style.opacity = "0%";
            notf.style.display = 'block';
            if(nome.value != '' && email.value != '' && senha.value != '' && confSenha.value != '') {
                if(senha.value != confSenha.value) {
                    notf.innerText = 'Senhas não correspondem.'
                    notf.style.opacity = "100%";
                }else if(senha.value.length < 8){
                    notf.innerText = 'A senha tem que ter no mínimo 8 caracteres.'
                    notf.style.opacity = "100%";
                }else if(nome.value.length < 5){
                    notf.innerText = 'O nome tem que ter no mínimo 5 caracteres.'
                    notf.style.opacity = "100%";
                }else if(!isEmail(email)){
                    notf.innerText = 'Digite um email válido.'
                    notf.style.opacity = "100%";
                }else{
                    form1.classList.add('active')
                    form2.classList.add('active')
                }
            }else{
                notf.innerText = 'Preencha todos os campos.'
                notf.style.opacity = "100%"
            }
        })
        
        inputFile.addEventListener('change', function(e){
            const inputTarget = e.target
            const file = inputTarget.files[0]
            const reader = new FileReader()
            reader.addEventListener('load', function(e){
                const readerTarget = e.target
                const img = document.createElement('img')
                img.src = readerTarget.result
                img.classList.add('picture_img')
                pictureImage.innerHTML = ''
                pictureImage.appendChild(img)
                pictureImageTxt.innerHTML = ''
            })
            reader.readAsDataURL(file)
        })
    </script>
</body>
</html>
