<?php
session_start();
include 'conexao.php';
include 'cart_functions.php';

requireLogin();

$cliente_id = $_SESSION['cliente_id'];

if (isset($_GET['remover'])) {
    $produto_id = intval($_GET['remover']);
    removeFromCart($conn, $cliente_id, $produto_id);
    header("Location: carrinho.php");
    exit;
}

if (isset($_POST['atualizar'])) {
    foreach ($_POST['quantidade'] as $produto_id => $qtd) {
        $produto_id = intval($produto_id);
        $qtd = max(1, intval($qtd));
        updateCartQuantity($conn, $cliente_id, $produto_id, $qtd);
    }
    header("Location: carrinho.php");
    exit;
}

$produtos = getCartItems($conn, $cliente_id);
$totalItens = getCartCount($conn, $cliente_id);
$totalPreco = getCartTotal($conn, $cliente_id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Soberano</title>
    <link rel="stylesheet" href="assets/css/carrinho.css">
</head>
<body>


<header id="navbar">
    <div class="header-container">
        <div class="menu-toggle" id="menu-toggle">
            <span></span><span></span><span></span>
        </div>
        <a href="index.php" class="logo">
            <img src="assets/img/logo.webp" alt="Logo da Soberano">
        </a>
        <nav class="navbar">
            <a href="index.php">Home</a>
            <a href="sobre.php">Sobre</a>
            <a href="produtos.php">Produtos</a>
            <a href="cadastro.php">Conta</a>
        </nav>
        <div class="icons">
            <a href="buscar.php"><img width="24" height="24" src="https://img.icons8.com/forma-bold/24/search.png" alt="Pesquisar"/></a>
            <span style="margin: 0 1em;">ㅤㅤ</span>
            <a href="carrinho.php"><img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="Carrinho"/></a>
        </div>
        <div class="sair">
                        <?php if (isLoggedIn()): ?>
                <a href="logout.php" class="sair" >Sair</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<main style="margin-top: 10rem;">
    <section class="carrinho-section">
        <h2 class="title">Seu Carrinho</h2>
        <div class="carrinho-wrapper">
            <form method="post">
                <div class="carrinho-container">
                    <?php if (empty($produtos)): ?>
                        <p class="empty-cart">Seu carrinho está vazio.</p>
                        <a href="produtos.php" class="btn">Continuar Comprando</a>
                    <?php else: ?>
                        <?php foreach ($produtos as $item): ?>
                            <div class="carrinho-item">
                                <img src="assets/img/<?php echo htmlspecialchars($item['imagem']); ?>" alt="<?php echo htmlspecialchars($item['nome']); ?>">
                                <div class="item-info">
                                    <h3><?php echo htmlspecialchars($item['nome']); ?></h3>
                                    <p class="preco">R$ <?php echo number_format($item['preco'],2,",","."); ?></p>
                                    <div class="quantidade">
                                        <button type="button" onclick="alterarQtd(<?php echo $item['produto_id']; ?>, -1)">-</button>
                                        <input type="number" name="quantidade[<?php echo $item['produto_id']; ?>]" id="qtd_<?php echo $item['produto_id']; ?>" value="<?php echo $item['quantidade']; ?>" min="1">
                                        <button type="button" onclick="alterarQtd(<?php echo $item['produto_id']; ?>, 1)">+</button>
                                    </div>
                                </div>
                                <div class="item-remove">
                                    <p class="subtotal">Subtotal: R$ <?php echo number_format($item['subtotal'],2,",","."); ?></p>
                                    <a href="carrinho.php?remover=<?php echo $item['produto_id']; ?>" class="remover">Remover</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <?php if (!empty($produtos)): ?>
                    <button type="submit" name="atualizar" class="btn">Atualizar Carrinho</button>
                <?php endif; ?>
            </form>

            <?php if (!empty($produtos)): ?>
            <div class="carrinho-summary">
                <h3>Resumo do Pedido</h3>
                <p>Itens: <span id="total-itens"><?php echo $totalItens; ?></span></p>
                <p class="total-preco">Total: R$ <span id="total-preco"><?php echo number_format($totalPreco,2,",","."); ?></span></p>
                <a href="checkout.php" class="btn btn-checkout">Finalizar Compra</a>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <div class="container-footer">
        <div class="row-footer">
            <div class="footer-col">
                <h4>Empresa</h4>
                <ul>
                    <li><a href="sobre.php">Quem somos</a></li>
                    <li><a href="cadastro.php">Crie sua Conta</a></li>
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

<script>
const menuToggle = document.getElementById('menu-toggle');
const nav = document.querySelector('.navbar');
menuToggle.addEventListener('click', () => nav.classList.toggle('active'));

function alterarQtd(id, delta) {
    const input = document.getElementById('qtd_' + id);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    input.value = val;
}
</script>
</body>
</html>
