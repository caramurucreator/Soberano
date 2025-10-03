<?php
session_start();
include 'conexao.php';
include 'cart_functions.php';

$mensagem = '';
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : '';
$add_product = isset($_GET['add']) ? intval($_GET['add']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    if (isset($_POST['cadastrar'])) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $verifica = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
        $verifica->bind_param("s", $email);
        $verifica->execute();
        $verifica->store_result();

        if ($verifica->num_rows > 0) {
            $mensagem = "Este e-mail já está cadastrado.";
        } else {
            $stmt = $conn->prepare("INSERT INTO clientes (email, senha) VALUES (?, ?)");
            $stmt->bind_param("ss", $email, $senha_hash);

            if ($stmt->execute()) {
                $mensagem = "Conta criada com sucesso! Faça login para continuar.";
            } else {
                $mensagem = "Erro ao cadastrar: " . $stmt->error;
            }
        }
    }

    if (isset($_POST['login'])) {
        $stmt = $conn->prepare("SELECT id, senha FROM clientes WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            if (password_verify($senha, $usuario['senha'])) {
                $_SESSION['cliente_id'] = $usuario['id'];
                $_SESSION['cliente_email'] = $email;
                
                migrateSessionCartToDatabase($conn, $usuario['id']);
                
                if (!empty($redirect)) {
                    if ($add_product > 0) {
                        addToCart($conn, $usuario['id'], $add_product, 1);
                        header("Location: " . $redirect . "?added=1");
                    } else {
                        header("Location: " . $redirect);
                    }
                } else {
                    header("Location: carrinho.php");
                }
                exit;
            } else {
                $mensagem = "Senha incorreta.";
            }
        } else {
            $mensagem = "Usuário não encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro/Login - Soberano</title>
    <link rel="stylesheet" href="assets/css/cadastro.css">
</head>
<body>
    <header id="navbar">
        <div class="header-container">
            <div class="menu-toggle" id="menu-toggle">
                <span></span><span></span><span></span>
            </div>
            <a href="index.php" class="logo">
                <img src="assets/img/logo.webp" alt="Logo" style="cursor:pointer;">
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

    <form method="post" action="cadastro.php<?php echo !empty($redirect) ? '?redirect=' . urlencode($redirect) . '&add=' . $add_product : ''; ?>">
        <h1>SOBERANO</h1>

        <?php if (!empty($mensagem)): ?>
            <p style="color: red;"><?php echo $mensagem; ?></p>
        <?php endif; ?>

        <label for="email">EMAIL:</label>
        <input type="email" name="email" id="email" required autocomplete="off"> <br>

        <label for="senha">SENHA:</label>
        <input type="password" name="senha" id="senha" required autocomplete="off"> <br>

        <input type="submit" name="cadastrar" value="CADASTRAR">
        <input type="submit" name="login" value="LOGIN">
    </form>

    <a href="admin/login.php" class="botao">Acessar como Administrador</a>

    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const nav = document.querySelector('.navbar');
        menuToggle.addEventListener('click', () => nav.classList.toggle('active'));
    </script>
</body>
</html>