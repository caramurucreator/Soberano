<?php
session_start();
include 'conexao.php';
include 'cart_functions.php';
include 'config.php';
require_once 'vendor/autoload.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Payment\PaymentClient;

header('Content-Type: application/json');

if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit;
}

$cliente_id = $_SESSION['cliente_id'];
$produtos = getCartItems($conn, $cliente_id);
$totalPreco = getCartTotal($conn, $cliente_id);

if (empty($produtos)) {
    echo json_encode(['success' => false, 'message' => 'Carrinho vazio']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
$payment_method = $input['payment_method'] ?? '';

if (empty($payment_method)) {
    echo json_encode(['success' => false, 'message' => 'Método de pagamento não especificado']);
    exit;
}

try {
    MercadoPagoConfig::setAccessToken(MERCADOPAGO_ACCESS_TOKEN);
    
    $stmt = $conn->prepare("INSERT INTO pedidos (cliente_id, total, status, metodo_pagamento) VALUES (?, ?, 'pendente', ?)");
    $stmt->bind_param("ids", $cliente_id, $totalPreco, $payment_method);
    $stmt->execute();
    $pedido_id = $stmt->insert_id;
    
    foreach ($produtos as $item) {
        $stmt = $conn->prepare("INSERT INTO pedidos_itens (pedido_id, produto_id, quantidade, preco_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiidd", $pedido_id, $item['produto_id'], $item['quantidade'], $item['preco'], $item['subtotal']);
        $stmt->execute();
    }
    
    if ($payment_method === 'pix') {
        $payment_data = [
            "transaction_amount" => floatval($totalPreco),
            "description" => "Pedido #" . $pedido_id . " - Soberano Moda Country",
            "payment_method_id" => "pix",
            "payer" => [
                "email" => $_SESSION['cliente_email']
            ]
        ];
        
        $client = new PaymentClient();
        $payment = $client->create($payment_data);
        
        $qr_code = $payment->point_of_interaction->transaction_data->qr_code ?? '';
        $qr_code_base64 = $payment->point_of_interaction->transaction_data->qr_code_base64 ?? '';
        $mp_id = $payment->id;
        
        $stmt = $conn->prepare("INSERT INTO pagamentos (pedido_id, mercadopago_id, status, metodo, valor, pix_qr_code, pix_qr_code_base64) VALUES (?, ?, ?, 'pix', ?, ?, ?)");
        $status = $payment->status;
        $stmt->bind_param("issdss", $pedido_id, $mp_id, $status, $totalPreco, $qr_code, $qr_code_base64);
        $stmt->execute();
        
        clearCart($conn, $cliente_id);
        
        echo json_encode([
            'success' => true,
            'pedido_id' => $pedido_id,
            'qr_code' => $qr_code,
            'qr_code_base64' => $qr_code_base64,
            'valor' => number_format($totalPreco, 2, ',', '.')
        ]);
        
    } else {
        $mp_id = 'DEMO_' . uniqid();
        $status = 'approved';
        
        $stmt = $conn->prepare("INSERT INTO pagamentos (pedido_id, mercadopago_id, status, metodo, valor) VALUES (?, ?, ?, ?, ?)");
        $metodo = $payment_method;
        $stmt->bind_param("isssd", $pedido_id, $mp_id, $status, $metodo, $totalPreco);
        $stmt->execute();
        
        $stmt = $conn->prepare("UPDATE pedidos SET status = 'pago' WHERE id = ?");
        $stmt->bind_param("i", $pedido_id);
        $stmt->execute();
        
        clearCart($conn, $cliente_id);
        
        echo json_encode([
            'success' => true,
            'pedido_id' => $pedido_id,
            'message' => 'Pagamento aprovado!'
        ]);
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao processar pagamento: ' . $e->getMessage()
    ]);
}
?>
