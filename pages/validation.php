<?php
include '../_php/crypto.php';
include '../_php/id_user.php';
include '../_php/crop_image.php';

session_start();
$nome = $_SESSION['user_name'];
$email = $_SESSION['user_email'];


if (!isset($_SESSION['code'])){
    // Set content-type header for sending HTML email 
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    $code = uniqidReal(6);
    $_SESSION['code'] = $code;
    $msg = "
    <!DOCTYPE html>
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <title>Tô Com Fome</title>
        <style>
        * {font-size: 18pt;}
        </style>
    </head>
    <body>
        Bem-vindo à Tô Com Fome, o lugar para saciar a sua fome!<br>
        Para continuar, você deve confirmar seu email com o código: <strong>$code</strong>.<br>
        Esperamos por você e agradecemos a sua inscrição!
    </body>
    </html>";
    
    mail($email, 'Tô Com Fome: Validação de Email', $msg, $headers);
}

# Dados de conexão
$host = "localhost";
$username = "root";
$password = "";

# Nome do bd
$dbase = "tocomfome";


try {
    $code_session = isset($_SESSION['code']) ? $_SESSION['code']: '';
    $code_input = $_POST['codigo'];
    $conn = new PDO("mysql:host=$host;dbname=$dbase", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($code_session == $code_input) {
        $data = $conn->query("UPDATE usuario SET active = 1 WHERE nome = '$nome'");
        $data = $conn->prepare('SELECT * FROM usuario WHERE nome = :nome');
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
        $email = $a->decript($emailcad, $s);
        $senha = $a->decript($passcad, $s);
        session_destroy();
        session_start();
        $_SESSION['user_id'] = $userid;
        $_SESSION['user_log'] = $nome;
        $_SESSION['user_pass'] = $pass;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_mebr'] = $membro;
        $_SESSION['user_img'] = $user_img;
        $_SESSION['user_adm'] = $user_adm;
        echo
        '<!DOCTYPE html>
        <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Lunaris</title>
            <link rel="stylesheet" href="../_styles/logonStyle.css">
            <link rel="shortcut icon" href="../_imagens/sistema/logo.png" type="image/x-icon">
            <meta http-equiv="refresh" content="0;URL=confcad">
        </head>
        <body>
        </body>';
        header("location: confcad.php");
        exit();
    }

    unset($data);
}catch(PDOException $e) {
    $z='';
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tô Com Fome</title>
    <link rel="stylesheet" href="../styles/logonStyle.css">
    <link rel="shortcut icon" href="../_imagens/sistema/logo.png" type="image/x-icon">
</head>
<body id = "validation">
    <header>
    </header>
    <div>
    <main>
        <div class="form val">
            <h2>Validação de E-mail.</h2>
            <br><p>Olá, <?php echo "$nome";?>. Código para validação de conta enviado para o e-mail: <?php echo "$email";?>.</p>
            <p>Copie e preencha este código no campo abaixo.</p>
            <form id="val" action="validation" method="post"> <br>
                
                <label for="codigo">Código:<div id="obri">*</div></label></br>
                <input type="text" class="campo" id="" name="codigo" required autofocus minlength="6" maxlength="6" placeholder = "Digite o código"><br>
                <a href = "validation">Reenviar código</a><br><br>
                <input type="submit" value="Validar" class="button" name="enviar">
                <br><br><div id="obri">*</div></label>Campo obrigatório.<br>
            </form>
        </div>
    </main>
    </div>
    <footer></footer>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
</body>
</html>
