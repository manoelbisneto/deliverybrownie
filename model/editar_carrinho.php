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

$item_id = $_POST['id'];
$nova_quantidade = $_POST['quantidade'];

// Atualiza a quantidade no carrinho
foreach ($_SESSION['carrinho'] as $key => $item) {
    if ($item['id'] == $item_id) {
        $_SESSION['carrinho'][$key]['quantidade'] = $nova_quantidade;
        break;
    }
}

// Redireciona de volta para o carrinho
header("Location: ../index.php?pag=carrinho");
exit();
?>
