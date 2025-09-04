<?php
include '../conexao.php';
include 'auth.php';


if (!isset($_GET['id'])) die("ID inválido");
$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = floatval($_POST['preco']);
    $categoria = $_POST['categoria'];
    $sexo = $_POST['sexo'];
    $imagem = $_POST['imagem'];

    $stmt = $conn->prepare("UPDATE produtos SET nome=?, descricao=?, preco=?, categoria=?, sexo=?, imagem=? WHERE id=?");
    $stmt->bind_param("ssdsssi", $nome, $descricao, $preco, $categoria, $sexo, $imagem, $id);

    if ($stmt->execute()) {
        header("Location: produtos.php");
        exit;
    } else {
        $erro = "Erro: " . $stmt->error;
    }
}

// Buscar dados atuais
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$produto = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Produto</title>
</head>
<body>
    <h1>Editar Produto</h1>
    <a href="produtos.php">⬅ Voltar</a>
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

    <form method="post">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?= htmlspecialchars($produto['nome']) ?>" required><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao" required><?= htmlspecialchars($produto['descricao']) ?></textarea><br><br>

        <label>Preço:</label><br>
        <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>" required><br><br>

        <label>Categoria:</label><br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($produto['categoria']) ?>" required><br><br>

        <label>Sexo:</label><br>
        <select name="sexo" required>
            <option value="masculino" <?= $produto['sexo']=='masculino'?'selected':'' ?>>Masculino</option>
            <option value="feminino" <?= $produto['sexo']=='feminino'?'selected':'' ?>>Feminino</option>
            <option value="unissex" <?= $produto['sexo']=='unissex'?'selected':'' ?>>Unissex</option>
        </select><br><br>

        <label>Imagem (nome do arquivo):</label><br>
        <input type="text" name="imagem" value="<?= htmlspecialchars($produto['imagem']) ?>" required><br><br>

        <input type="submit" value="Salvar Alterações">
    </form>
</body>
</html>
