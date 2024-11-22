<?php
@session_start();
// Verifica se o usuário está logado
if (!isset($_SESSION['tipo'])) {
    header("Location: ../index.php");
    exit;
}

// Conexão com o banco de dados
include_once("../configuration/config.inc.php");

// Verifica se o ID do pedido foi passado
if (!isset($_GET['id'])) {
    header("Location: ../views/gerenciar_pedidos.php?status=erro");
    exit;
}

$pedido_id = intval($_GET['id']);

// Busca os detalhes do pedido
$pedido_query = "SELECT p.id, p.criado_em, p.estado, p.preco_total, u.nome AS cliente
                 FROM pedidos p
                 JOIN usuarios u ON p.usuarios_id = u.id
                 WHERE p.id = ?";
$stmt = $conn->prepare($pedido_query);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$pedido_result = $stmt->get_result();

if ($pedido_result->num_rows === 0) {
    header("Location: ../views/gerenciar_pedidos.php?status=erro");
    exit;
}

$pedido = $pedido_result->fetch_assoc();

// Busca os itens do pedido
$itens_query = "SELECT i.id, i.nome, ip.quantidade, ip.preco 
                FROM itens_pedidos ip
                JOIN itens_menu i ON ip.itens_menu_id = i.id
                WHERE ip.pedidos_id = ?";
$stmt = $conn->prepare($itens_query);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$itens_result = $stmt->get_result();
?>

    <h1>Detalhes do Pedido #<?php echo $pedido['id']; ?></h1>

    <p><strong>Cliente:</strong> <?php echo htmlspecialchars($pedido['cliente']); ?></p>
    <p><strong>Data do Pedido:</strong> <?php echo date("d/m/Y H:i", strtotime($pedido['criado_em'])); ?></p>
    <p><strong>Status:</strong> <?php echo ucfirst($pedido['estado']); ?></p>
    <p><strong>Total (R$):</strong> <?php echo number_format($pedido['preco_total'], 2, ',', '.'); ?></p>

    <h2>Itens do Pedido</h2>
    <?php if ($itens_result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>Nome do Item</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário (R$)</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $itens_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome']); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td><?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td><?php echo number_format($item['quantidade'] * $item['preco'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há itens neste pedido.</p>
    <?php endif; ?>

    <?php if ($pedido['estado'] === 'pendente'): ?>
        <h2>Ações</h2>
        <a href="../model/alterar_estado.php?id=<?php echo $pedido['id']; ?>&estado=cancelado" 
           onclick="return confirm('Tem certeza que deseja cancelar este pedido?');">Cancelar Pedido</a>
    <?php endif; ?>

    <a href="../index.php?pag=pedidos">Voltar</a>
