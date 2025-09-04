<?php
include 'auth.php';
include '../conexao.php';

$resultado = $conn->query("SELECT * FROM clientes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Clientes - Admin</title>
    <link rel="stylesheet" href="../assets/css/adminprodutos.css">
</head>
<body>
    <h1>Gerenciar Clientes</h1>
    <a href="index.php">⬅ Voltar</a>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while($c = $resultado->fetch_assoc()): ?>
            <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['email']) ?></td>
                <td>
                    <a href="editar_cliente.php?id=<?= $c['id'] ?>">Editar</a> |
                    <a href="excluir_cliente.php?id=<?= $c['id'] ?>" onclick="return confirm('Confirma exclusão?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
