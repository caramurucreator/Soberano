<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soberano</title>
    <link rel="stylesheet" href="assets/css/stylesobre.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredericka+the+Great&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/favicon.ico" type="image/x-icon">    
</head>

<body>
<header id="navbar">
    <div class="header-container">
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <a href="#" class="logo">
            <img src="assets/img/logo.webp" alt="fds" onclick="window.location.href='index.php'" style="cursor:pointer;">
        </a>

        <nav class="navbar">
            <a href="index.php">Home</a>      
            <a href="sobre.php">Sobre</a> 
            <a href="produtos.php">Produtos</a>
            <a href="cadastro.php">Conta</a>
        </nav>

        <div class="icons">
            <img width="24" height="24" src="https://img.icons8.com/forma-bold/24/search.png" alt="search"/>
            <span style="margin: 0 1em;">ㅤㅤ</span>
            <a href="carrinho.php">
                <img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="shopping-cart"/>
            </a>
        </div>
    </div>
</header>

    <section class="sobre">
        <div class="conteudo">
            <h3>EQUIPE SOBERANO</h3>
            <p>Nossa EQUIPE formada por 5 estudantes, foi criada em 2025 para relançar ao mundo a tendência "Country", o estilo de vida que foi muito presente no mundo nos anos 80.</p>
            <a href="produtos.php" class="btn">Confira nossos produtos</a>
        </div>
    </section>
</body>

        <footer>
        <div class="container-footer">
            <div class="row-footer">
                <!-- footer col-->
                <div class="footer-col">
                    <h4>Empresa</h4>
                    <ul>
                        <li><a href="sobre.php"> Quem somos </a></li>
                        <li><a href="cadastro.php"> Crie sua Conta </a></li>
                    </ul>
                </div>
                <!--end footer col-->
                <!-- footer col-->
                <div class="footer-col">
                    <h4>Produtos</h4>
                    <ul>
                        <li><a href="#">Chapéus</a></li>
                        <li><a href="#">Cintos</a></li>
                        <li><a href="#">Calças</a></li>
                        <li><a href="#">Botinas</a></li>
                    </ul>
                </div>
                <!--end footer col-->

            </div>
        </div>
    </footer>


    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const nav = document.querySelector('.navbar'); // Alterado para pegar a classe navbar

        menuToggle.addEventListener('click', () => {
        nav.classList.toggle('active'); // Toga a classe active no menu
});

    </script>

</html>
