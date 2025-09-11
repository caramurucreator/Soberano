<?php
include '../conexao.php';
include 'auth.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = floatval($_POST['preco']);
    $categoria = $_POST['categoria'];
    $sexo = $_POST['sexo'];
    $imagem = $_POST['imagem']; // nome da imagem já salva em assets/img/

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, categoria, sexo, imagem) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdsss", $nome, $descricao, $preco, $categoria, $sexo, $imagem);

    if ($stmt->execute()) {
        header("Location: produtos.php");
        exit;
    } else {
        $erro = "Erro: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Adicionar Produto</title>
    <link rel="stylesheet" href="../assets/css/addproduto.css">
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
<div class="texto1">
    <h1>Adicionar Produto</h1>
    <a href="produtos.php">⬅ Voltar</a>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>
</div>
    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required></textarea><br><br>

        <label>Preço:</label><br>
        <input type="number" name="preco" step="0.01" required><br><br>

        <label>Categoria:</label><br>
        <select name="categoria" required><br><br>
            <option value="botinas">Botinas</option>
            <option value="chapeis">Chapéis</option>
            <option value="cintos">Cintos</option>
            <option value="calcas">Calças</option>
        </select><br><br>
            
        <label>Sexo:</label><br>
        <select name="sexo" required>
            <option value="masculino">Masculino</option>
            <option value="feminino">Feminino</option>
            <option value="unissex">Unissex</option>
        </select><br><br>

        <label>Imagem (nome do arquivo):</label><br>
        <input type="text" name="imagem" placeholder="ex: produto1.jpg" required><br><br>

        <input type="submit" value="Adicionar Produto">
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
