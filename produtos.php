<?php
session_start();
include 'conexao.php';

// Adiciona ao carrinho se houver parâmetro ?add=ID
if (isset($_GET['add'])) {
    $id = intval($_GET['add']);
    if (!isset($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    if (isset($_SESSION['carrinho'][$id])) {
        $_SESSION['carrinho'][$id]++;
    } else {
        $_SESSION['carrinho'][$id] = 1;
    }

    // Redireciona para evitar múltiplos envios ao recarregar
    header("Location: produtos.php");
    exit;
}

// Pegar filtros de categoria e sexo, se existirem
$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';
$sexo = isset($_GET['sexo']) ? $_GET['sexo'] : '';

// Montar consulta dinâmica
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soberano</title>
    <link rel="stylesheet" href="assets/css/styleprodutos.css">
    <style>
        .filtros {
            text-align: center;
            margin: 2rem 0;
        }
        .filtros .btn {
            margin: 0 0.5rem 1rem;
            padding: 0.8rem 1.5rem;
            font-size: 1.3rem;
            font-weight: bold;
            border-radius: 1.5rem;
            transition: 0.3s;
        }
        .filtros .btn:hover {
            transform: scale(1.05);
        }

        .produtos-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        .produto-card {
            width: 220px;
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .produto-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }
        .produto-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        .produto-card h3 {
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
        }
        .produto-card p {
            font-size: 1rem;
            color: #555;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .produto-card .preco {
            font-weight: bold;
            font-size: 1.2rem;
            margin: 0.5rem 0;
        }
        .produto-card .botao {
            display: inline-block;
            padding: 0.6rem 1.3rem;
            background-color: var(--main-color);
            color: var(--black);
            border-radius: 1.5rem;
            font-weight: bold;
            transition: 0.3s;
        }
        .produto-card .botao:hover {
            background-color: var(--black);
            color: var(--main-color);
            transform: scale(1.1);
        }

        @media (max-width: 768px){
            .produtos-container { flex-direction: column; align-items: center; }
            .produto-card { width: 90%; }
        }
    </style>
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

        <!-- FILTROS -->
        <div class="filtros">
            <a href="produtos.php" class="btn">Todos</a>
            <a href="produtos.php?categoria=botinas" class="btn">Botinas</a>
            <a href="produtos.php?categoria=chapeus" class="btn">Chapéus</a>
            <a href="produtos.php?categoria=cintos" class="btn">Cintos</a>
            <a href="produtos.php?categoria=calcas" class="btn">Calças</a>
            <br>
            <a href="produtos.php?sexo=masculino" class="btn">Masculino</a>
            <a href="produtos.php?sexo=feminino" class="btn">Feminino</a>
        </div>

        <!-- PRODUTOS -->
        <div class="produtos-container">
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="produto-card">
                    <img src="assets/img/<?php echo $row['imagem']; ?>" alt="<?php echo $row['nome']; ?>">
                    <h3><?php echo $row['nome']; ?></h3>
                    <p><?php echo $row['descricao']; ?></p>
                    <p class="preco">R$ <?php echo number_format($row['preco'],2,",","."); ?></p>
                    <a href="produtos.php?add=<?php echo $row['id']; ?>" class="botao">Adicionar</a>
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
