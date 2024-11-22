<?php
@session_start();
include_once("../configuration/config.inc.php");

if (!isset($_GET['id'])) {
    echo "ID do item não fornecido.";
    exit;
}

$id = $_GET['id'];

// Busca os dados do item no banco
$query = "SELECT * FROM itens_menu WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    echo "Item não encontrado.";
    exit;
}

// Busca categorias para preencher o dropdown
$categorias_query = "SELECT id, categoria FROM categorias";
$categorias_result = $conn->query($categorias_query);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Item</title>
</head>
<body>
    <h1>Editar Item</h1>
    <form action="../model/editar_item.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">

        <label for="nome">Nome do Item:</label>
        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($item['nome']); ?>" required><br><br>

        <label for="descricao">Descrição:</label>
        <textarea id="descricao" name="descricao" rows="3"><?php echo htmlspecialchars($item['descricao']); ?></textarea><br><br>

        <label for="preco">Preço (R$):</label>
        <input type="number" id="preco" name="preco" step="0.01" min="0" value="<?php echo htmlspecialchars($item['preco']); ?>" required><br><br>

        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria" required>
            <?php while ($categoria = $categorias_result->fetch_assoc()): ?>
                <option value="<?php echo $categoria['id']; ?>" <?php echo $categoria['id'] == $item['categorias_id'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($categoria['categoria']); ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <label for="disponivel">Disponível:</label>
        <input type="checkbox" id="disponivel" name="disponivel" value="1" <?php echo $item['disponivel'] == 1 ? 'checked' : ''; ?>><br><br>

        <button type="submit">Salvar Alterações</button>
        <button onclick="history.back()" class="btn btn-danger">Voltar</button>
    </form>
</body>
</html>