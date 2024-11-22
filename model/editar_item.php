<?php
@include_once("../configuration/config.inc.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria = $_POST['categoria'];
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;

    // Atualiza os dados no banco
    $query = "UPDATE itens_menu SET nome = ?, descricao = ?, preco = ?, categorias_id = ?, disponivel = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssdiii", $nome, $descricao, $preco, $categoria, $disponivel, $id);

    if ($stmt->execute()) {
        header("Location: ../view/cardapio.php?status=editado");
    } else {
        echo "Erro ao atualizar o item: " . $conn->error;
    }
}
?>
