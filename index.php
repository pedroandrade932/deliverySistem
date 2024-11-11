<?php
    //-- inclui a criptografia
    include '_php/crypto.php';
    //-- inicia a sessão
    session_start();

    //-- Variável de controle de sessão
    $logon = false;

    //-- Verifica se existe uma sessão ativa (se existir, pega as informações da conta)
    $userid;
    $nome;
    $email;
    $foto;
    foreach ($_SESSION as $key=>$val){
        if ($key == 'user_id'){
            $userid = $val;
        }
        if ($key == 'user_log'){
            $nome = $val;
            $logon = true;
        }
        if ($key == 'user_email'){
            $email = $val;
        }
        if($key == 'user_img'){
            $foto = $val;
        }
    }



# Dados de conexão
$host = "localhost";
$username = "ialuana_tocomfome_root";
$password = "<Ma3t3mcaf3?>";

# Nome do bd
$dbase = "ialuana_tocomfome";

try {
    $comment = $_POST["msg"];
    $datah = date('Y-m-d');
    $conn = new PDO("mysql:host=$host;dbname=$dbase", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if ($comment != ''){
        $data = $conn->prepare('SELECT * FROM usuario WHERE nome = :nome');
        $data->execute(array('nome' => $nome));
        $result = $data->fetchAll();
        $data = $conn->query("INSERT INTO msgs (iduser, msg, data_envio) VALUES ($userid, '$comment', '$datah')");
        
    }unset($data);

}catch(PDOException $e) {
    $z='';
    echo 'ERROR: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tô Com Fome - Bem vindo!</title>
    <link rel="stylesheet" href="styles/homePage.css">
    <link rel="stylesheet" href="styles/itemFilter.css">
    <link rel="stylesheet" href="styles/feedback.css">
    <link rel="stylesheet" href="styles/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
    <link rel="shortcut icon" href="_imagens/sistema/logo.png" type="image/x-icon">
</head>

<body>
    <!-- janela modal com o forms e os comentários -->
    <div class="janelaFeedback" id="janelaFeedback">
        <!-- janela interna interna da janela modal -->
        <div class="modalFeedback" id="modalFeedback">
            <div class="modal-feedback-body" id="feedBody">
                <!-- formulário -->
                <div class="content-forms" id="contentForms">
                    <div class="titleChat">
                        <h1>Tô com fome chat</h1>
                    </div>
                    <br>
                    <?php
                        if($logon){
                            echo '
                            <form class="form" action="index" method="post">
                                <div class="mensagem-form">
                                    <label for="msg">
                                        <span>O que achou da gente?</span>
                                        <textarea name="msg" id="msg" placeholder="Mensagem..."></textarea>
                                    </label>
                                </div>
                                <!-- botão enviar -->
                                <div class="btn-submit">
                                    <input class="submit" type="submit" value="Enviar">
                                </div>
                            </form>';
                        }else{
                            echo "<h3 style='text-align:center'>Para fazer um cometário, <a href='pages/cadastro'>cadastre-se</a> ou <a href='pages/login'>entre na sua conta</a></h3>";
                        }
                    ?>
                </div>
                <!-- janela de comentários -->
                <section class="content-chat mySwiper" id="contentChat">
                    <div class="depoimentos-container swiper-wrapper">
                        <!-- sliders com os comentários -->
                            <?php
                                //-- Busca todos os comentarios
                                
                                try {
                                    $data2 = $conn->prepare('SELECT * FROM msgs');
                                    $data2->execute();
                                    $result = $data2->fetchAll();
                                    if (count($result)) {
                                        foreach($result as $row) {
                                            $iduser = $row[1];
                                            $msg = $row[2];
                                            $data_envio = $row[3];
                                            
                                            $data3 = $conn->prepare('SELECT nome, foto FROM usuario WHERE iduser = :id');
                                            $data3->execute(array('id' => $iduser));
                                            $result2 = $data3->fetchAll();
                                            if ( count($result2) ) {
                                                foreach($result2 as $row2) {
                                                    $nome_comment = $row2[0];
                                                    $foto_comment = $row2[1];
                                                }
                                            }
                                            echo "
                                            <div class='slider swiper-slide'>
                                                <div class='iconSlider'>
                                                    <i class='bi bi-quote'></i>
                                                </div>
                                                <div class='msgSlider'>
                                                    <p>$msg</p>
                                                </div>
                                                <!-- imagem e nome do usuário -->
                                                <div class='userInfo'>
                                                    <img class='icon-login' src='_imagens/users/$foto_comment'>
                                                    <p class='namePerson'>$nome_comment</p>
                                                </div>
                                            </div>
                                            ";
                                            unset($data3);
                                            
                                        }
                                    }
                                    unset($data2);
                                }catch(PDOException $e) {
                                    $z='';
                                    echo 'ERROR: ' . $e->getMessage();
                                }
                            ?>
                    </div>
                    <!-- botões de navegação do slider -->
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-pagination"></div>
                </section>
                <!-- botão de ativação do feed para dispositivos móveis -->
                <div class="openComents" onclick="openFeed()"><i class="bi bi-menu-up" id="iconFeed"></i></div>
            </div>
        </div>
        <!-- botão para fechar a janela -->
        <div class="btnClose-feedback">
            <button class="btnClose-feed">
                <span class="material-symbols-outlined" id="btnClose-feed">
                    close
                </span>
            </button>
        </div>
    </div>
    <!-- Cabeçalho -->
    <header id="header">
        <!-- Logo -->
        <div class="logo">
            <img src="_imagens/sistema/logo.png" alt="" height="80px">
        </div>
        <!-- Ferramentas de ícones -->
        <div class="icons">
            <div class="searchBar">
                <input class="search" id="search" type="search" name="" id="" placeholder="Diga lá, moral...">
            </div>
            <div class="lupa" id="lupa">
                <span class="material-symbols-outlined icon">
                    search
                </span>
            </div>
            <div class="carrinho">
                <span class="material-symbols-outlined icon">
                    shopping_cart
                </span>
            </div>
            <div class="chat" onclick="openChat()">
                <span class="material-symbols-outlined icon">
                    chat
                </span>
            </div>
            <?php
                //-- Mudar entre Cadastrar/Entrar e Perfil de Usuário
                if($logon){
                    echo "
                    <div class='perfil' onclick='openPerfil()'>
                        <span class='material-symbols-outlined icon'>
                            <img class='icon-login' src='_imagens/users/$foto'>
                        </span>
                    </div>";
                }else{
                    echo '
                    <div class="perfil login">
                        <a class="btn-logon" href="pages/cadastro.php">
                            Cadastro/Login
                        </a>
                    </div>';
                }
            ?>
        </div>
    </header>
    <!-- Conteúdo -->
    <main class="content">
        <!-- Banner -->
        <section class="banner">
            <img src="_imagens/sistema/banner_home_page.png" alt="">
        </section>
        <!-- Parte de filtro -->
        <section class="filters">
            <div class="filterMobile" onclick="openFilter()">
                <div class="iconFilter" id="iconFilter">
                    <span class="lineFilter lineFilter01"></span>
                    <span class="lineFilter lineFilter02"></span>
                    <span class="lineFilter lineFilter03"></span>
                </div>
            </div>
            <!-- Conteúdo do filtro -->
            <div class="container-filters" id="content-filter">
                <div class="option">
                    <span>
                        <h2 class="openOption">Tipos de Pratos
                            <div class="iconOption">
                                <span class="material-symbols-outlined open" data-drop="open">
                                    arrow_drop_down
                                </span>
                                <span class="material-symbols-outlined restaurant">
                                    restaurant
                                </span>
                            </div>
                        </h2>
                        <!-- Menu com as opções de filtro -->
                        <div class="menuDropdown">
                            <ul class="itemFilter">
                                <li>Pratos Principais</li>
                                <li>Saladas</li>
                                <li>Bebidas</li>
                                <li>Bebidas</li>
                                <li>Bebidas</li>
                                <li>Bebidas</li>
                                <li>Bebidas</li>
                            </ul>
                        </div>
                    </span>

                </div>
                <div class="option">
                    <span>
                        <h2 class="openOption">Tipos de culinárias
                            <div class="iconOption">
                                <span class="material-symbols-outlined open">
                                    arrow_drop_down
                                </span>
                                <span class="material-symbols-outlined restaurant">
                                    restaurant
                                </span>
                            </div>
                        </h2>
                        <div class="menuDropdown" id="menuDrop">
                            <ul class="itemFilter">
                                <li>Italiana</li>
                                <li>Japonesa</li>
                                <li>Brasileira</li>
                            </ul>
                        </div>
                    </span>

                </div>
                <div class="option">
                    <span>
                        <h2 class="openOption">Preferências Alimentares
                            <div class="iconOption">
                                <span class="material-symbols-outlined open" id="iconOption">
                                    arrow_drop_down
                                </span>
                                <span class="material-symbols-outlined restaurant">
                                    restaurant
                                </span>
                            </div>
                        </h2>
                        <div class="menuDropdown">
                            <ul class="itemFilter">
                                <li>Vegetariano</li>
                                <li>Vegano</li>
                                <li>Sem Glúten</li>
                            </ul>
                        </div>
                    </span>

                </div>
            </div>
        </section>
        <!-- Área de alimentos -->
        <section class="foods">
            <div class="titleFoods">
                <h1>Comidas Rápidas e Populares</h1>
            </div>
            <div class="containerFoods">
                <!-- Card de alimento -->
                <div class="cardFoods">
                    <!-- Imagem do alimento -->
                    <div class="imgFood">
                        <img src="_imagens/sistema/cardsFood/hamburguer-artesanal-scaled.jpg" alt="" height="200px">
                    </div>
                    <!-- Descrição do alimento -->
                    <div class="description">
                        <div class="nameFood">
                            <h3>Hambuerguer Artesanal</h3>
                        </div>
                        <!-- Valor -->
                        <div class="valueFood">
                            <h2>R$24,99</h2>
                            <span class="line"></span>
                            <h2>20min</h2>
                        </div>
                        <!-- Botão para informação sobre o alimento -->
                        <div class="btnInfo" onclick="openInfo()">
                            <button>Info</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- janela modal de informação dos alimentos -->
        <div class="janelaModalInfo" id="janelaModalInfo">
            <div class="modalInfo" id="modalInfo">
                <div class="modalBody-info" id="modalBodyInfo">
                    <div id="btnClose-modalInfo">
                        <button class="btnCloseInfo" id="closeInfo">X</button>
                    </div>
                    <div class="content-info">
                        <!-- imagem do alimento -->
                        <div class="img-top">
                            <img src="_imagens/sistema/cardsFood/hamburguer-artesanal-scaled.jpg" alt="" height="200px">
                        </div>
                        <!-- descrição do alimento -->
                        <div class="status-info">
                            <div class="descriptionFood">
                                <p>Descrição: Pão brioche tostado, hambúrguer 100% carne bovina, queijo cheddar
                                    derretido, fatias de bacon crocante, alface fresca, tomate, cebola roxa e molho
                                    especial da casa.</p>
                            </div>
                            <!-- botão de comprar -->
                            <div class="btnComprar">
                                <button class="btnBuy">Preço R$24,99</button>
                            </div>
                            <div class="destaques">
                                <div class="destaques-content">
                                    <h2>Destaques:</h2>
                                    <hr>
                                    <ul>
                                        <li>Feito com ingredientes frescos e selecionados.</li>
                                        <li>Opção de pão: Brioche, integral ou australiano.
                                            Escolha o ponto da carne: Malpassado, ao ponto, bem passado.</li>
                                        <li>Adicionais: Queijo extra, ovo, cebola caramelizada (R$ 3,00 cada).</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- Janela modal com o perfil do usuário -->
    <?php
    echo "
    <div class='janelaModal' id='janelaModal'>
        <div class='modal' id='modal'>
            <div class='modalBody' id='modalBody'>
                <div id='btnClose'>
                    <button class='close' id='close'>X</button>
                </div>
                <div class='contentPerson'>
                    <div class='person'>
                        <div class='iconPerson'>
                            <span class='material-symbols-outlined user'>
                                <img class='icon-login-modal' src='_imagens/users/$foto'>
                            </span>
                        </div>
                        <div class='name'>
                            <h1>$nome</h1>
                        </div>
                        <div class='name'>
                            <h3>$email</h3>
                        </div>
                    </div>
                    <div class='optionPerson'>
                        <ul>
                            <li>
                                <a href=''>Pedidos</a>
                            </li>
                            <li>
                                <a href=''>Conta</a>
                            </li>
                            <li>
                                <a href='pages/logout'>Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>";
    ?>
    <footer>
        <div class="copy">
            SODEF &copy;2024
        </div>
    </footer>
    <script src="_scripts/main.js"></script>
    <script src="_scripts/swiper-bundle.min.js"></script>
    <script src="_scripts/slider.js"></script>
</body>

</html>