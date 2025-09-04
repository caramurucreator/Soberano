<?php
include 'auth.php';
include '../conexao.php';

if (!isset($_GET['id'])) {
    die("ID inválido.");
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM clientes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: clientes.php");
exit;
