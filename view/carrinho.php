<?php
@session_start();
include_once ("./configuration/config.inc.php");

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

$carrinho = $_SESSION['carrinho'];
$total = 0;
?>

<h1>Carrinho de Compras</h1>

<!-- Exibe os itens do carrinho -->
<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Preço (R$)</th>
            <th>Quantidade</th>
            <th>Subtotal (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($carrinho as $item): ?>
            <?php
                $subtotal = $item['preco'] * $item['quantidade'];
                $total += $subtotal;
            ?>
            <tr>
                <td><?php echo htmlspecialchars($item['nome']); ?></td>
                <td><?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                <td>
                    <!-- Formulário para alterar a quantidade -->
                    <form action="./model/editar_carrinho.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1" required>
                        <button type="submit">Alterar</button>
                    </form>
                </td>
                <td><?php echo number_format($subtotal, 2, ',', '.'); ?></td>
                <td>
                    <!-- Botão para remover o item do carrinho -->
                    <a href="./model/remover_item_carrinho.php?id=<?php echo $item['id']; ?>">Remover</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Exibe o total -->
<p><strong>Total: R$ <?php echo number_format($total, 2, ',', '.'); ?></strong></p>

<!-- Botão para finalizar o pedido -->
<a href="./model/finalizar_pedido.php">
    <button>Finalizar Pedido</button>
</a>

<p><a href="index.php?pag=cardapio">Voltar ao cardápio</a></p>
