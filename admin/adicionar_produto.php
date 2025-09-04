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
</head>
<body>
    <h1>Adicionar Produto</h1>
    <a href="produtos.php">⬅ Voltar</a>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required></textarea><br><br>

        <label>Preço:</label><br>
        <input type="number" name="preco" step="0.01" required><br><br>

        <label>Categoria:</label><br>
        <input type="text" name="categoria" required><br><br>

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
</body>
</html>
