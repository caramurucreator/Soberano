<?php
$host = "localhost";
$user = "soberano";
$pass = "123";
$db   = "soberano";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}
?>
