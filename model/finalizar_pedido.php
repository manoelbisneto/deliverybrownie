<?php
@session_start();
include_once("../configuration/config.inc.php"); // Certifique-se de que o arquivo de configuração está correto

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Verifica se o carrinho não está vazio
if (empty($_SESSION['carrinho'])) {
    echo "<p>Seu carrinho está vazio. <a href='./index.php?pag=cardapio'>Voltar ao cardápio</a></p>";
    exit();
}

// Recupera os itens do carrinho e o usuário
$carrinho = $_SESSION['carrinho'];
$usuario_id = $_SESSION['usuario_id'];
$total = 0;

// Calcula o total do pedido
foreach ($carrinho as $item) {
    $subtotal = $item['preco'] * $item['quantidade'];
    $total += $subtotal;
}

// Inicia uma transação para garantir que o pedido seja registrado corretamente
$conn->begin_transaction();

try {
    // Insere o pedido na tabela de pedidos com o estado 'pendente'
    $sql_pedido = "INSERT INTO pedidos (usuarios_id, estado, preco_total) VALUES (?, 'pendente', ?)";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("id", $usuario_id, $total);
    $stmt_pedido->execute();
    
    // Recupera o ID do pedido inserido
    $pedido_id = $stmt_pedido->insert_id;

    // Insere os itens do carrinho na tabela de itens_pedidos
    $sql_item_pedido = "INSERT INTO itens_pedidos (pedidos_id, itens_menu_id, quantidade, preco) VALUES (?, ?, ?, ?)";
    $stmt_item_pedido = $conn->prepare($sql_item_pedido);

    foreach ($carrinho as $item) {
        $stmt_item_pedido->bind_param("iiid", $pedido_id, $item['id'], $item['quantidade'], $item['preco']);
        $stmt_item_pedido->execute();
    }

    // Se tudo correr bem, confirma a transação
    $conn->commit();

    // Limpa o carrinho de compras
    unset($_SESSION['carrinho']);

    // Exibe mensagem de sucesso
    echo "<h2>Pedido Finalizado com Sucesso!</h2>";
    echo "<p>Seu pedido foi registrado com sucesso.</p>";
    echo "<p><a href='../index.php?pag=pedidos'>Meus Pedidos</a></p>";
} catch (Exception $e) {
    // Se algo der errado, reverte a transação
    $conn->rollback();
    echo "<p>Ocorreu um erro ao processar seu pedido. Tente novamente mais tarde.</p>";
    echo "<p><a href='index.php?pag=cardapio'>Voltar ao cardápio</a></p>";
}

$conn->close();
?>
