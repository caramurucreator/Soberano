<?php
include 'auth.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Painel Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <header id="navbar">
    <div class="header-container">
        <div class="menu-toggle" id="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <a href="../index.php" class="logo">
            <img src="../assets/img/logo.webp" alt="Logo da Soberano" style="cursor:pointer;">
        </a>

        <nav class="navbar">
            <a href="produtos.php">Produtos</a>
            <a href="clientes.php">Clientes</a>

        </nav>

        <div class="icons">
            <a href="../buscar.php"><img width="24" height="24" src="https://img.icons8.com/forma-bold/24/search.png" alt="Pesquisar"/></a>
            <span style="margin: 0 1em;">ㅤㅤ</span>
            <a href="../carrinho.php">
                <img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="Carrinho de Compras"/>
            </a>
        </div>
        <a href="logout.php" class="logout-btn">Sair</a>    
</div>
</header>

<div>
    <h1>Bem-vindo ao Painel Administrador</h1>
    <h2>Caso deseje voltar à tela de PRODUTOS para conferência, selecione abaixo:</h2>

    <div class="usuario_p">
        <a href="../produtos.php" class="btn">Análise de produtos</a>
    </div>
</div>

<footer>
    <div class="container-footer">
        <div class="row-footer">
            <div class="footer-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="../sobre.php">Quem somos</a></li>
                    <li><a href="clientes.php">Altere os usuários</a></li>
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



</body>
<script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.querySelector('.navbar');

    menuToggle.addEventListener('click', () => {
        nav.classList.toggle('active');
    });

</script>
</html>
