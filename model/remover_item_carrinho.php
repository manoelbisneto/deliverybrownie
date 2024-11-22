<?php
@session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o carrinho existe
if (!isset($_SESSION['carrinho'])) {
    header("Location: carrinho.php");
    exit();
}

$item_id = $_GET['id'];

// Remove o item do carrinho
foreach ($_SESSION['carrinho'] as $key => $item) {
    if ($item['id'] == $item_id) {
        unset($_SESSION['carrinho'][$key]);
        break;
    }
}

// Redireciona de volta para o carrinho
header("Location: ../index.php?pag=carrinho");
exit();
?>
