<?php
@session_start();
// Verifica se o usuário é admin
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Conexão com o banco de dados
include_once("../configuration/config.inc.php");

// Verifica se o ID e o estado foram passados
if (isset($_GET['id']) && isset($_GET['estado'])) {
    $id = intval($_GET['id']);
    $novo_estado = $_GET['estado'];

    // Verifica se o estado é válido
    $estados_validos = ['pendente', 'completo', 'cancelado'];
    if (!in_array($novo_estado, $estados_validos)) {
        // Armazena a mensagem de erro na sessão
        $_SESSION['mensagem'] = "Estado inválido.";
        header("Location: ../views/gerenciar_pedidos.php");
        exit;
    }

    // Atualiza o estado do pedido
    $query = "UPDATE pedidos SET estado = ?, atualizado_em = NOW() WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $novo_estado, $id);

    if ($stmt->execute()) {
        // Armazena a mensagem de sucesso na sessão
        $_SESSION['mensagem'] = "Estado do pedido atualizado com sucesso para '$novo_estado'.";
    } else {
        // Armazena a mensagem de erro na sessão
        $_SESSION['mensagem'] = "Erro ao atualizar o estado do pedido.";
    }
} else {
    // Caso o ID ou estado não tenha sido passado, armazena uma mensagem de erro na sessão
    $_SESSION['mensagem'] = "Informações incompletas.";
}

// Redireciona de volta para a página de gerenciamento de pedidos

if ($_SESSION['tipo'] === 'admin') {
    header("Location: ../index.php?pag=gerenciar_pedidos");
} else {
    header("Location: ../index.php?pag=pedidos");
}    
exit;
