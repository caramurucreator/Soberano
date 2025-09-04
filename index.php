<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soberano</title>
    <meta name="description" content="Soberano - Loja de modas country que vem para revolucionar a moda agro. Chapéus, botinas, cintos e muito mais.">
    <meta name="keywords" content="moda country, agro, soberano, chapéu, botina, cinto, calça country">
    
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
</head>

<body>
<header id="navbar">
    <div class="header-container">
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <a href="index.php" class="logo">
            <img src="assets/img/logo.webp" alt="Logo da Soberano" style="cursor:pointer;">
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>      
            <a href="sobre.php">Sobre</a> 
            <a href="produtos.php">Produtos</a>
            <a href="cadastro.php">Conta</a>
        </nav>

        <div class="icons">
            <a href="buscar.php"><img width="24" height="24" src="https://img.icons8.com/forma-bold/24/search.png" alt="Pesquisar"/></a>
            <span style="margin: 0 1em;">ㅤㅤ</span>
            <a href="carrinho.php">
                <img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="Carrinho de Compras"/>
            </a>
        </div>
    </div>
</header>

<main>
    <div class="banner1">
        <section id="home">
            <div class="content">
                <h3>BEM-VINDO À <span>SOBERANO</span></h3>
                <p>O LOCAL DOS AGROS</p>
                <a href="produtos.php" class="botao">Compre Já!</a>
            </div>
        </section>
    </div>

    <div class="about">
        <section class="sobre">
            <div class="conteudo">
                <h3>O QUE FAZ A NOSSA MODA SER ESPECIAL</h3>
                <p>A Soberano traz autenticidade, tradição e estilo do campo para a cidade. Qualidade e confiança em cada detalhe.</p>
                <a href="sobre.php" class="btn">Veja mais sobre</a>
            </div>
        </section>
    </div>
</main>

<footer>
    <div class="container-footer">
        <div class="row-footer">
            <div class="footer-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="sobre.php">Quem somos</a></li>
                    <li><a href="cadastro.php">Crie sua Conta</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Produtos</h4>
                <ul>
                    <li><a href="produtos.php?categoria=chapeus">Chapéus</a></li>
                    <li><a href="produtos.php?categoria=cintos">Cintos</a></li>
                    <li><a href="produtos.php?categoria=calcas">Calças</a></li>
                    <li><a href="produtos.php?categoria=botinas">Botinas</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.querySelector('.navbar');

    menuToggle.addEventListener('click', () => {
        nav.classList.toggle('active');
    });
</script>

</body>
</html>
