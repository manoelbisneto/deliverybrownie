<?php
@session_start();
include_once("./configuration/config.inc.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Busca os pedidos do usuário
$query_pedidos = "SELECT id, estado, preco_total, criado_em FROM pedidos WHERE usuarios_id = ? ORDER BY criado_em DESC";
$stmt_pedidos = $conn->prepare($query_pedidos);
$stmt_pedidos->bind_param("i", $usuario_id);
$stmt_pedidos->execute();
$result_pedidos = $stmt_pedidos->get_result();
?>

<h1>Meus Pedidos</h1>

<?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
    <p>Pedido realizado com sucesso!</p>
<?php endif; ?>

<table border="1" cellpadding="10" cellspacing="0">
    <thead>
        <tr>
            <th>ID do Pedido</th>
            <th>Data</th>
            <th>Status</th>
            <th>Total (R$)</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($pedido = $result_pedidos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $pedido['id']; ?></td>
                <td><?php echo date("d/m/Y H:i:s", strtotime($pedido['criado_em'])); ?></td>
                <td><?php echo ucfirst($pedido['estado']); ?></td>
                <td><?php echo number_format($pedido['preco_total'], 2, ',', '.'); ?></td>
                <td>
                    <a href="view/detalhes_pedido.php?id=<?php echo $pedido['id']; ?>">Ver Detalhes</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
