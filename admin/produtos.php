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

    <h1>Gerenciar Produtos</h1>
            <a href="index.php" class="btn">⬅ Voltar</a>
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
