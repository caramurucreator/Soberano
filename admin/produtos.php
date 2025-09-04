<?php
include '../conexao.php';
include 'auth.php';

$resultado = $conn->query("SELECT * FROM produtos ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos - Admin</title>
    <link rel="stylesheet" href="../assets/css/adminprodutos.css">
</head>
<body>
    <h1>Gerenciar Produtos</h1>
            <a href="index.php" class="btn">Voltar ao painel</a>
            <a href="adicionar_produto.php" class="btn">+ Novo produto</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Categoria</th>
                <th>Sexo</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while($p = $resultado->fetch_assoc()): ?>
            <tr>
                <td data-label="ID"><?= $p['id'] ?></td>
                <td data-label="Nome"><?= htmlspecialchars($p['nome']) ?></td>
                <td data-label="Preço">R$ <?= number_format($p['preco'],2,",",".") ?></td>
                <td data-label="Categoria"><?= htmlspecialchars($p['categoria']) ?></td>
                <td data-label="Sexo"><?= htmlspecialchars($p['sexo']) ?></td>
                <td data-label="Imagem">
                    <img src="../assets/img/<?= $p['imagem'] ?>" width="50" alt="Imagem do produto">
                </td>
                <td data-label="Ações">
                    <a href="editar_produto.php?id=<?= $p['id'] ?>">Editar</a> 
                    <a href="excluir_produto.php?id=<?= $p['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
