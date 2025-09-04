<?php
include '../conexao.php';
include 'auth.php';


if (!isset($_GET['id'])) {
    die("ID inválido.");
}
$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: produtos.php");
exit;
