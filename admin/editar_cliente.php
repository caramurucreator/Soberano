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
</body>
</html>
