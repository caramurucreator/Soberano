<?php
// cadastro.php
require_once "conexao.php"; // Conexão com banco

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome  = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Verifica se o e-mail já existe
    $check = $conn->prepare("SELECT id FROM clientes WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $mensagem = "E-mail já cadastrado!";
    } else {
        $sql = "INSERT INTO clientes (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, $senha);

        if ($stmt->execute()) {
            $mensagem = "✅ Cadastro realizado com sucesso!";
        } else {
            $mensagem = "❌ Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    }
    $check->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Soberano</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Soberano</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Início</a></li>
                    <li><a href="login.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="form-section">
        <h2>Cadastro de Cliente</h2>
        <?php if ($mensagem) echo "<p>$mensagem</p>"; ?>
        <form method="POST">
            <input type="text" name="nome" placeholder="Nome completo" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit" class="btn">Cadastrar</button>
        </form>
    </section>
</body>
</html>
