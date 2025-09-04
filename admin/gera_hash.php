<?php
$senha = 'soberano123'; // troque para a senha que quiser
$hash = password_hash($senha, PASSWORD_DEFAULT);
echo $hash;
?>
