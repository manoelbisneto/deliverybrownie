<?php
@session_start();
// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// Conexão com o banco de dados
include_once("./configuration/config.inc.php");

// Consulta para buscar todos os pedidos pendentes
$pendentes_query = "SELECT p.id, p.criado_em, p.preco_total, u.nome AS cliente
                    FROM pedidos p
                    JOIN usuarios u ON p.usuarios_id = u.id
                    WHERE p.estado = 'pendente'
                    ORDER BY p.criado_em ASC";
$pendentes_result = $conn->query($pendentes_query);

// Consulta para buscar todos os pedidos (independentemente do estado)
$todos_pedidos_query = "SELECT p.id, p.criado_em, p.estado, p.preco_total, u.nome AS cliente
                        FROM pedidos p
                        JOIN usuarios u ON p.usuarios_id = u.id
                        ORDER BY p.criado_em DESC";
$todos_pedidos_result = $conn->query($todos_pedidos_query);
?>

<h1>Gerenciar Pedidos</h1>

<!-- Exibindo Mensagem de Sucesso ou Erro -->
<?php if (isset($_SESSION['mensagem'])): ?>
    <p><?php echo $_SESSION['mensagem']; ?></p>
    <?php unset($_SESSION['mensagem']); // Limpa a mensagem após exibição ?>
<?php endif; ?>

<!-- Pedidos Pendentes -->
<section>
    <h2>Pedidos Pendentes</h2>
    <?php if ($pendentes_result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Total (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $pendentes_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($pedido['criado_em'])); ?></td>
                        <td><?php echo number_format($pedido['preco_total'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="view/detalhes_pedido.php?id=<?php echo $pedido['id']; ?>">Ver Detalhes</a> |
                            <a href="./model/alterar_estado.php?id=<?php echo $pedido['id']; ?>&estado=completo" 
                               onclick="return confirm('Marcar como completo?');">Completar</a> |
                            <a href="./model/alterar_estado.php?id=<?php echo $pedido['id']; ?>&estado=cancelado" 
                               onclick="return confirm('Cancelar este pedido?');">Cancelar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há pedidos pendentes.</p>
    <?php endif; ?>
</section>

<!-- Todos os Pedidos -->
<section>
    <h2>Todos os Pedidos</h2>
    <?php if ($todos_pedidos_result->num_rows > 0): ?>
        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Total (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($pedido = $todos_pedidos_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $pedido['id']; ?></td>
                        <td><?php echo htmlspecialchars($pedido['cliente']); ?></td>
                        <td><?php echo date("d/m/Y H:i", strtotime($pedido['criado_em'])); ?></td>
                        <td><?php echo ucfirst($pedido['estado']); ?></td>
                        <td><?php echo number_format($pedido['preco_total'], 2, ',', '.'); ?></td>
                        <td>
                            <a href="view/detalhes_pedido.php?id=<?php echo $pedido['id']; ?>">Ver Detalhes</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Não há pedidos cadastrados.</p>
    <?php endif; ?>
</section>
