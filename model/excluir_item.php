<?php
@include_once("../configuration/config.inc.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Deleta o item do banco
    $query = "DELETE FROM itens_menu WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: ../view/cardapio.php?status=excluido");
    } else {
        echo "Erro ao excluir o item: " . $conn->error;
    }
} else {
    echo "ID do item não fornecido.";
}
?>
