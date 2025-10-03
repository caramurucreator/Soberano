<?php
session_start();
include 'conexao.php';
include 'cart_functions.php';
include 'config.php';

requireLogin();

$cliente_id = $_SESSION['cliente_id'];
$produtos = getCartItems($conn, $cliente_id);
$totalItens = getCartCount($conn, $cliente_id);
$totalPreco = getCartTotal($conn, $cliente_id);

if (empty($produtos)) {
    header("Location: carrinho.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Soberano</title>
    <link rel="stylesheet" href="assets/css/checkout.css">
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
            <a href="carrinho.php"><img width="26" height="26" src="https://img.icons8.com/material-rounded/24/shopping-cart.png" alt="Carrinho"/></a>
        </div>
    </div>
</header>

<main style="margin-top: 10rem;">
    <section class="checkout-section">
        <h2 class="title">Finalizar Compra</h2>
        
        <div class="checkout-container">
            <div class="order-summary">
                <h3>Resumo do Pedido</h3>
                <?php foreach ($produtos as $item): ?>
                    <div class="item-row">
                        <span><?php echo htmlspecialchars($item['nome']); ?> (x<?php echo $item['quantidade']; ?>)</span>
                        <span>R$ <?php echo number_format($item['subtotal'], 2, ",", "."); ?></span>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="total-row">
                    <strong>Total:</strong>
                    <strong>R$ <?php echo number_format($totalPreco, 2, ",", "."); ?></strong>
                </div>
            </div>

            <div class="payment-section">
                <h3>Escolha o Método de Pagamento</h3>
                
                <div class="payment-methods">
                    <button class="payment-btn" onclick="selectPayment('pix')">
                        <img src="https://img.icons8.com/color/48/pix.png" alt="Pix"/>
                        Pagar com PIX
                    </button>
                    
                    <button class="payment-btn" onclick="selectPayment('credito')">
                        <img src="https://img.icons8.com/color/48/bank-card-back-side.png" alt="Cartão"/>
                        Cartão de Crédito
                    </button>
                    
                    <button class="payment-btn" onclick="selectPayment('debito')">
                        <img src="https://img.icons8.com/color/48/bank-card-back-side.png" alt="Débito"/>
                        Cartão de Débito
                    </button>
                </div>

                <div id="pix-payment" class="payment-form" style="display: none;">
                    <h4>Pagamento via PIX</h4>
                    <p>Clique no botão abaixo para gerar o código PIX</p>
                    <button class="btn-submit" onclick="processPixPayment()">Gerar Código PIX</button>
                    <div id="pix-result"></div>
                </div>

                <div id="cartao-pagamento" class="payment-form" style="display: none;">
                    <h4>Pagamento com Cartão</h4>
                    <form id="cartao-form" onsubmit="processcartaoPayment(event)">
                        <input type="hidden" id="payment-method" name="payment_method">
                        
                        <label>Nome no Cartão:</label>
                        <input type="text" id="cartao-holder-name" required>
                        
                        <label>Número do Cartão:</label>
                        <input type="text" id="cartao-number" maxlength="19" required placeholder="1234 5678 9012 3456">
                        
                        <div class="cartao-row">
                            <div>
                                <label>Validade:</label>
                                <input type="text" id="cartao-expiry" maxlength="5" required placeholder="MM/AA">
                            </div>
                            <div>
                                <label>CVV:</label>
                                <input type="text" id="cartao-cvv" maxlength="4" required placeholder="123">
                            </div>
                        </div>
                        
                        <button type="submit" class="btn-submit">Finalizar Pagamento</button>
                    </form>
                    <div id="cartao-result"></div>
                </div>
            </div>
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

function selectPayment(method) {
    document.getElementById('pix-payment').style.display = 'none';
    document.getElementById('cartao-pagamento').style.display = 'none';
    
    if (method === 'pix') {
        document.getElementById('pix-payment').style.display = 'block';
    } else {
        document.getElementById('payment-method').value = method;
        document.getElementById('cartao-pagamento').style.display = 'block';
    }
}

function processPixPayment() {
    document.getElementById('pix-result').innerHTML = '<p>Processando...</p>';
    
    fetch('process_payment.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({payment_method: 'pix'})
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let html = '<div class="pix-qr-code">';
            html += '<h4>Escaneie o QR Code abaixo:</h4>';
            html += '<img src="' + data.qr_code_base64 + '" alt="QR Code PIX" style="max-width: 300px;">';
            html += '<p><strong>Ou copie o código:</strong></p>';
            html += '<textarea readonly style="width: 100%; height: 80px;">' + data.qr_code + '</textarea>';
            html += '<p>Valor: R$ ' + data.valor + '</p>';
            html += '<a href="pedido_confirmado.php?id=' + data.pedido_id + '" class="btn">Já paguei</a>';
            html += '</div>';
            document.getElementById('pix-result').innerHTML = html;
        } else {
            document.getElementById('pix-result').innerHTML = '<p style="color: red;">Erro: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        document.getElementById('pix-result').innerHTML = '<p style="color: red;">Erro ao processar pagamento</p>';
    });
}

function processcartaoPayment(event) {
    event.preventDefault();
    
    const formData = {
        payment_method: document.getElementById('payment-method').value,
        cartao_holder_name: document.getElementById('cartao-holder-name').value,
        cartao_number: document.getElementById('cartao-number').value.replace(/\s/g, ''),
        cartao_expiry: document.getElementById('cartao-expiry').value,
        cartao_cvv: document.getElementById('cartao-cvv').value
    };
    
    document.getElementById('cartao-result').innerHTML = '<p>Processando...</p>';
    
    fetch('process_payment.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'pedido_confirmado.php?id=' + data.pedido_id;
        } else {
            document.getElementById('cartao-result').innerHTML = '<p style="color: red;">Erro: ' + data.message + '</p>';
        }
    })
    .catch(error => {
        document.getElementById('cartao-result').innerHTML = '<p style="color: red;">Erro ao processar pagamento</p>';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const cartaoNumber = document.getElementById('cartao-number');
    if (cartaoNumber) {
        cartaoNumber.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }
    
    const cartaoExpiry = document.getElementById('cartao-expiry');
    if (cartaoExpiry) {
        cartaoExpiry.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                e.target.value = value.substring(0, 2) + '/' + value.substring(2, 4);
            } else {
                e.target.value = value;
            }
        });
    }
});
</script>
</body>
</html>