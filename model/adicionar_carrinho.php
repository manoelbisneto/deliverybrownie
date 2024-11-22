<?php
session_start();
include_once("../configuration/config.inc.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['mensagem'] = "Você precisa estar logado para adicionar itens ao carrinho.";
    header("Location: ../view/login.php");
    exit();
}

// Verifica se o ID do item foi fornecido
if (isset($_GET['id'])) {
    $item_id = (int)$_GET['id'];

    // Verifica se o item existe no banco de dados
    $item_query = "SELECT id, nome, preco FROM itens_menu WHERE id = ?";
    $stmt = $conn->prepare($item_query);
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $item_result = $stmt->get_result();

    if ($item_result->num_rows > 0) {
        $item = $item_result->fetch_assoc();

        // Se o carrinho não existir na sessão, cria um novo
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }

        // Adiciona o item ao carrinho, verificando se já está presente
        $item_encontrado = false;
        foreach ($_SESSION['carrinho'] as &$carrinho_item) {
            if ($carrinho_item['id'] == $item_id) {
                $carrinho_item['quantidade']++;
                $item_encontrado = true;
                break;
            }
        }

        // Se o item não estiver no carrinho, adiciona com quantidade 1
        if (!$item_encontrado) {
            $_SESSION['carrinho'][] = [
                'id' => $item['id'],
                'nome' => $item['nome'],
                'preco' => $item['preco'],
                'quantidade' => 1
            ];
        }

        // Define a mensagem de sucesso
        $_SESSION['mensagem'] = "Item '{$item['nome']}' adicionado ao carrinho com sucesso!";
    } else {
        // Caso o item não exista, define a mensagem de erro
        $_SESSION['mensagem'] = "Erro: Item não encontrado.";
    }
} else {
    // Caso o ID do item não seja passado, define a mensagem de erro
    $_SESSION['mensagem'] = "Erro: Nenhum item selecionado.";
}

// Redireciona de volta para o cardápio
header("Location: ../index.php?pag=cardapio");
exit();
