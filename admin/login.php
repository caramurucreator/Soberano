<?php
session_start();
include '../conexao.php'; // Conexão com o banco de dados

// Se já estiver logado como administrador, redireciona para o painel
if (isset($_SESSION['admin'])) {
    header("Location: index.php");
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Prepara a consulta para buscar o administrador no banco
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = ?");
    $stmt->bind_param("s", $usuario); // Usa email como parâmetro
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário existe
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();

        // Definindo o hash pré-existente
        $senhaHash = '$2y$10$bptYX/feETz/w2jt4vBQGelenmGMwLwVpQKQveFCFA0fOgwfVSG5q';

        // Compara a senha fornecida com o hash fornecido (senha estática)
        if (password_verify($senha, $senhaHash)) {
            // A senha está correta, inicia a sessão de administrador
            $_SESSION['admin'] = $admin['email']; // Salva o e-mail na sessão
            header("Location: index.php"); // Redireciona para o painel de administração
            exit;
        } else {
            // Se a senha estiver incorreta
            $erro = "Senha incorreta.";
        }
    } else {
        // Se o usuário não for encontrado
        $erro = "Usuário não encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Login Admin</title>
    <link rel="stylesheet" href="../assets/css/loginadmin.css">
</head>
<body>

    <!-- Exibe mensagem de erro caso haja -->
    <?php if (isset($erro)) echo "<p style='color:red;'>$erro</p>"; ?>

    <!-- Formulário de login -->
    <form method="post">
            <h1>Login Admin</h1>

        <label>Usuário:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Senha:</label><br>
        <input type="password" name="senha" required><br><br>

        <input type="submit" value="Entrar">
        <a href="../cadastro.php">Voltar ao site</a>
    </form>
</body>
</html>
