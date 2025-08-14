    <?php
    // compra.php
    session_start();
    require_once "conexao.php";

    // Exemplo de produto fixo (depois puxaremos do banco)
    $produto = [
        "nome" => "Bota Country Premium",
        "preco" => 389.90,
        "quantidade" => 1
    ];

    $total = $produto['preco'] * $produto['quantidade'];

    $mensagem = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pagamento = $_POST['pagamento'];

        $mensagem = "Compra confirmada! Método de pagamento: $pagamento. Total: R$ " . number_format($total, 2, ',', '.');
    }
    ?>
    <!DOCTYPE html>
    <html lang="pt">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Compra - Soberano</title>
        <link rel="stylesheet" href="assets/css/style.css">
    </head>
    <body>
        <header>
            <div class="container">
                <h1>Soberano</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Início</a></li>
                        <li><a href="produtos.php">Produtos</a></li>
                    </ul>
                </nav>
            </div>
        </header>

        <section class="compra-section">
            <h2>Finalizar Compra</h2>
            <?php if ($mensagem) echo "<p>$mensagem</p>"; ?>
            <div class="produto-detalhe">
                <h3><?= $produto['nome'] ?></h3>
                <p>Preço: R$ <?= number_format($produto['preco'], 2, ',', '.') ?></p>
                <p>Quantidade: <?= $produto['quantidade'] ?></p>
                <p><strong>Total: R$ <?= number_format($total, 2, ',', '.') ?></strong></p>
            </div>

            <form method="POST">
                <label>Método de Pagamento:</label>
                <select name="pagamento" required>
                    <option value="">Selecione</option>
                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                    <option value="Pix">Pix</option>
                    <option value="Boleto Bancário">Boleto Bancário</option>
                </select>
                <button type="submit" class="btn">Confirmar Compra</button>
            </form>
        </section>
    </body>
    </html>
