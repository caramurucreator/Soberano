<?php
session_start();
include 'conexao.php';
?>

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
        <a href="produtos.php" class="ativo">Produtos</a>
        <a href="cadastro.php">Conta</a>
    </nav>

    <div class="icons">
        <a href="buscar.php"><img width="24" height="24" src="https://img.icons8.com/forma-bold/24/search.png" alt="Pesquisar"/></a>
        <span style="margin: 0 1em;">ㅤㅤ</span>
        <a href="carrinho.php">
            <img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="Carrinho de Compras"/>
        </a>
    </div>
</header>

<main>
    <!-- BANNER PRINCIPAL -->
    <section id="home" class="banner1">
        <div class="content">
            <h3>BEM-VINDO À <span>SOBERANO</span></h3>
            <p>A verdadeira casa da moda country!</p>
            <div class="banner-images">
                <img src="assets/img/banner.webp" alt="Imagem 1">
                <img src="assets/img/banner_inicio.webp" alt="Imagem 2">
                <img src="assets/img/banner.webp" alt="Imagem 3">
            </div>
            <a href="#produtos" class="botao">Compre Já!</a>
        </div>
    </section>

    <!-- SEÇÃO DE PRODUTOS ALEATÓRIOS -->
    <?php
// Busca 4 produtos aleatórios
$sql = "SELECT id, nome, descricao, preco, imagem FROM produtos ORDER BY RAND() LIMIT 4";
$result = $conn->query($sql);
?>

<div class="produtos-container">
    <?php if ($result && $result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="produto-card">
                <img src="assets/img/<?php echo htmlspecialchars($row['imagem']); ?>" 
                     alt="<?php echo htmlspecialchars($row['nome']); ?>">
                <h3><?php echo htmlspecialchars($row['nome']); ?></h3>
                <p><?php echo htmlspecialchars($row['descricao']); ?></p>
                <p class="preco">R$ <?php echo number_format($row['preco'], 2, ",", "."); ?></p>
                <a href="produtos.php" class="botao">Ver Mais</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
</div>


    <!-- SEÇÃO SOBRE -->
     <div class="about">
    <section class="sobre">
        <div class="conteudo">
            <h3>O QUE FAZ A NOSSA MODA SER ESPECIAL</h3>
            <div class="banner-images">
                <img src="assets/img/pessoa1.webp" alt="Pessoa 1">
                <img src="assets/img/pessoa2.webp" alt="Pessoa 2">
                <img src="assets/img/pessoa3.webp" alt="Pessoa 3">
            </div>
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
        </div>
    </div>
</footer>

<script>
    const menuToggle = document.getElementById('menu-toggle');
    const nav = document.querySelector('.navbar');
    menuToggle.addEventListener('click', () => nav.classList.toggle('active'));
</script>

</body>
</html>
