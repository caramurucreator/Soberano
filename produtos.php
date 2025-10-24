<?php
session_start();
include 'conexao.php';
include 'cart_functions.php';

if (isset($_GET['add'])) {
    if (!isLoggedIn()) {
        header("Location: cadastro.php?redirect=produtos.php&add=" . intval($_GET['add']));
        exit;
    }
    
    $produto_id = intval($_GET['add']);
    $cliente_id = $_SESSION['cliente_id'];
    addToCart($conn, $cliente_id, $produto_id, 1);
    header("Location: produtos.php?added=1");
    exit;
}

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sexo = isset($_GET['sexo']) ? $_GET['sexo'] : '';

$query = "SELECT * FROM produtos WHERE 1=1";
$params = [];
$types = "";

if($categoria != ''){
    $query .= " AND categoria = ?";
    $params[] = $categoria;
    $types .= "s";
}
if($sexo != ''){
    $query .= " AND sexo = ?";
    $params[] = $sexo;
    $types .= "s";
}

$stmt = $conn->prepare($query);
if(count($params) > 0){
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

$itemAdded = isset($_GET['added']) && $_GET['added'] == 1;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Soberano</title>
    <link rel="stylesheet" href="assets/css/styleprodutos.css">
</head>
<body>
<header id="navbar">
    <div class="header-container">
        <div class="menu-toggle" id="menu-toggle">
            <span></span><span></span><span></span>
        </div>
        <a href="index.php" class="logo"><img src="assets/img/logo.webp" alt="Logo da Soberano"></a>
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
    </div>
</header>

<main style="margin-top: 10rem;">
    <section>
        <h2 class="title">Produtos</h2>

        <?php if ($itemAdded): ?>
            <div style="background: #4CAF50; color: white; padding: 1rem; text-align: center; margin: 1rem auto; border-radius: 5px; max-width: 600px;">
                Produto adicionado ao carrinho! <a href="carrinho.php" style="color: white; text-decoration: underline;">Ver carrinho</a>
            </div>
        <?php endif; ?>

        <div class="filtros">
            <a href="produtos.php" class="botao">Todos</a>
            <a href="produtos.php?categoria=botinas" class="botao">Botinas</a>
            <a href="produtos.php?categoria=chapeus" class="botao">Chapéus</a>
            <a href="produtos.php?categoria=cintos" class="botao">Cintos</a>
            <a href="produtos.php?categoria=calcas" class="botao">Calças</a>
            <br>
            <a href="produtos.php?sexo=masculino" class="botao">Masculino</a>
            <a href="produtos.php?sexo=feminino" class="botao">Feminino</a>
        </div>

        <div class="produtos-container">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="produto-card">
                    <img src="assets/img/<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>">
                    <h3><?php echo $row['nome']; ?></h3>
                    <p><?php echo $row['descricao']; ?></p>
                    <p class="preco">R$ <?php echo number_format($row['preco'],2,",","."); ?></p>
                    <a href="produtos.php?add=<?php echo $row['id']; ?>" class="botao">Adicionar ao Carrinho</a>
                </div>
            <?php endwhile; ?>
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
    menuToggle.addEventListener('click', () => { nav.classList.toggle('active'); });
</script>
</body>
</html>