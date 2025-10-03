<?php
// Cart Management Functions

function isLoggedIn() {
    return isset($_SESSION['cliente_id']) && !empty($_SESSION['cliente_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: cadastro.php?redirect=" . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function addToCart($conn, $cliente_id, $produto_id, $quantidade = 1) {
    $stmt = $conn->prepare("INSERT INTO carrinhos (cliente_id, produto_id, quantidade) 
                            VALUES (?, ?, ?) 
                            ON DUPLICATE KEY UPDATE quantidade = quantidade + ?");
    $stmt->bind_param("iiii", $cliente_id, $produto_id, $quantidade, $quantidade);
    return $stmt->execute();
}

function removeFromCart($conn, $cliente_id, $produto_id) {
    $stmt = $conn->prepare("DELETE FROM carrinhos WHERE cliente_id = ? AND produto_id = ?");
    $stmt->bind_param("ii", $cliente_id, $produto_id);
    return $stmt->execute();
}

function updateCartQuantity($conn, $cliente_id, $produto_id, $quantidade) {
    if ($quantidade <= 0) {
        return removeFromCart($conn, $cliente_id, $produto_id);
    }
    
    $stmt = $conn->prepare("UPDATE carrinhos SET quantidade = ? WHERE cliente_id = ? AND produto_id = ?");
    $stmt->bind_param("iii", $quantidade, $cliente_id, $produto_id);
    return $stmt->execute();
}

function getCartItems($conn, $cliente_id) {
    $query = "SELECT c.id as cart_id, c.quantidade, c.produto_id,
                     p.nome, p.descricao, p.preco, p.imagem, p.estoque,
                     (c.quantidade * p.preco) as subtotal
              FROM carrinhos c
              JOIN produtos p ON c.produto_id = p.id
              WHERE c.cliente_id = ?
              ORDER BY c.data_adicao DESC";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    
    return $items;
}

function getCartTotal($conn, $cliente_id) {
    $query = "SELECT SUM(c.quantidade * p.preco) as total
              FROM carrinhos c
              JOIN produtos p ON c.produto_id = p.id
              WHERE c.cliente_id = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['total'] ?? 0;
}

function getCartCount($conn, $cliente_id) {
    $query = "SELECT SUM(quantidade) as total FROM carrinhos WHERE cliente_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $cliente_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['total'] ?? 0;
}

function clearCart($conn, $cliente_id) {
    $stmt = $conn->prepare("DELETE FROM carrinhos WHERE cliente_id = ?");
    $stmt->bind_param("i", $cliente_id);
    return $stmt->execute();
}

function migrateSessionCartToDatabase($conn, $cliente_id) {
    if (!isset($_SESSION['carrinho']) || empty($_SESSION['carrinho'])) {
        return true;
    }
    
    foreach ($_SESSION['carrinho'] as $produto_id => $quantidade) {
        addToCart($conn, $cliente_id, $produto_id, $quantidade);
    }
    
    unset($_SESSION['carrinho']);
    return true;
}
?>