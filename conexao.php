<?php
$host = "localhost";
$user = "soberano_user";
$pass = "senhaSegura123";
$db   = "soberano";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
