<?php
// compra.php
session_start();
require_once "conexao.php";
?>



<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soberano - Moda Country</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1>Soberano</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="produtos.php">Produtos</a></li>
                    <li><a href="sobre.php">Nossa Empresa</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="hero">

        <div class="hero-text">
            <h2>BEM VINDO À SOBERANO</h2>
            <p>O LEGADO QUE VOCÊ <strong>VESTE!"</strong></p>
            <a href="produtos.php" class="btn">Ver Coleção</a>
        </div>
        <div class="hero-image">
            <img src="assets/img/boid.jpg" alt="Moda Country">
    </section>

    <section class="destaques">
        <h3>Destaques da Semana</h3>
        <div class="produtos-grid">
            
            <div class="produto-card">
                <img src="assets/img/bota-country.jpg" alt="Bota Country">
                <h4>Bota Country Premium</h4>
                <p>R$ 389,90</p>
                <a href="produto.php?id=1" class="btn-small">Ver Produto</a>
            </div>
            <div class="produto-card">
                <img src="assets/img/chapéu.jpg" alt="Chapéu">
                <h4>Chapéu de Couro</h4>
                <p>R$ 149,90</p>
                <a href="produto.php?id=2" class="btn-small">Ver Produto</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Soberano | Todos os direitos reservados.</p>
    </footer>
</body>
</html>
