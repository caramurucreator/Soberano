<?php
include 'auth.php';
include '../conexao.php';

if (!isset($_GET['id'])) die("ID inválido");
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if (empty($senha)) {
        // Atualiza só email
        $stmt = $conn->prepare("UPDATE clientes SET email=? WHERE id=?");
        $stmt->bind_param("si", $email, $id);
    } else {
        // Atualiza email e senha (com hash)
        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE clientes SET email=?, senha=? WHERE id=?");
        $stmt->bind_param("ssi", $email, $hash, $id);
    }

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit;
    } else {
        $erro = "Erro: " . $stmt->error;
    }
}

$stmt = $conn->prepare("SELECT * FROM clientes WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cliente = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="../assets/css/admincliente.css">
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

    <h1>Editar Cliente</h1>
    <a href="clientes.php">⬅ Voltar</a>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

    <form method="post">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']) ?>" required><br><br>

        <label>Senha (deixe vazio para não alterar):</label><br>
        <input type="password" name="senha"><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>
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
</html>
