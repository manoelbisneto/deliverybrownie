<h1>Cardápio de Brownies</h1>

<?php
@session_start();
// Verifica se o usuário está logado e qual o tipo de usuário
$tipo_usuario = isset($_SESSION['tipo']) ? $_SESSION['tipo'] : 'usuario';

// Conexão com o banco de dados
include_once ("configuration/config.inc.php"); 

// Busca as categorias do banco
$categorias_query = "SELECT id, categoria FROM categorias";
$categorias_result = $conn->query($categorias_query);

// Define a consulta SQL de acordo com o tipo de usuário
if ($tipo_usuario === 'admin') {
    // Para admin, busca todos os itens, incluindo os não disponíveis
    $itens_query = "SELECT id, nome, descricao, preco, disponivel, categorias_id FROM itens_menu";
} else {
    // Para usuário, busca apenas os itens disponíveis
    $itens_query = "SELECT id, nome, descricao, preco, disponivel, categorias_id FROM itens_menu WHERE disponivel = 1";
}
$itens_result = $conn->query($itens_query);
?>

<?php if ($tipo_usuario === 'admin'): ?>
    <!-- Formulário para adicionar novo item ao cardápio -->
    <section>
        <h2>Adicionar Novo Item</h2>
        <form action="../model/adicionar_item.php" method="POST">
            <label for="nome">Nome do Item:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="3"></textarea><br><br>

            <label for="preco">Preço (R$):</label>
            <input type="number" id="preco" name="preco" step="0.01" min="0" required><br><br>

            <label for="categoria">Categoria:</label>
            <select id="categoria" name="categoria" required>
                <?php while ($categoria = $categorias_result->fetch_assoc()): ?>
                    <option value="<?php echo $categoria['id']; ?>"><?php echo htmlspecialchars($categoria['categoria']); ?></option>
                <?php endwhile; ?>
            </select><br><br>

            <label for="disponivel">Disponível:</label>
            <input type="checkbox" id="disponivel" name="disponivel" value="1" checked><br><br>

            <button type="submit">Adicionar Item</button>
        </form>
    </section>
<?php endif; ?>

<?php if (isset($_GET['status']) && $_GET['status'] == 'sucesso'): ?>
    <p>Item adicionado com sucesso!</p>
<?php endif; ?>

<!-- Lista de itens do cardápio -->
<section>
    <h2>Itens do Cardápio</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Preço (R$)</th>
                <th>Categoria</th>
                <?php if ($tipo_usuario === 'admin'): ?>
                    <th>Disponível</th>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario_logado'])): ?>
                    <th>Ações</th>
                <?php endif; ?>

            </tr>
        </thead>
        <tbody>
            <?php while ($item = $itens_result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nome']); ?></td>
                    <td><?php echo htmlspecialchars($item['descricao']); ?></td>
                    <td><?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                    <td>
                        <?php
                        // Recupera o nome da categoria conforme o ID
                        $categoria_id = $item['categorias_id'];
                        $categoria_nome_query = "SELECT categoria FROM categorias WHERE id = $categoria_id";
                        $categoria_nome_result = $conn->query($categoria_nome_query);
                        $categoria_nome = $categoria_nome_result->fetch_assoc();
                        echo htmlspecialchars($categoria_nome['categoria']);
                        ?>
                    </td>
                    <?php if ($tipo_usuario === 'admin'): ?>
                        <td><?php echo ($item['disponivel'] == 1) ? 'Sim' : 'Não';?></td>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['usuario_logado'])): ?>
                        <td>
                            <?php if ($tipo_usuario === 'admin'): ?>
                                <!-- Ações para admin -->
                                <a href="view/editar_item_form.php?id=<?php echo $item['id']; ?>">Editar</a> |
                                <a href="./model/excluir_item.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este item?');">Excluir</a> |
                                <a href="./model/adicionar_carrinho.php?id=<?php echo $item['id']; ?>">Adicionar ao Carrinho</a>
                            <?php endif; ?>
                            <?php if($tipo_usuario === 'usuario'): ?>
                                <!-- Ações para usuário -->
                                <a href="./model/adicionar_carrinho.php?id=<?php echo $item['id']; ?>">Adicionar ao Carrinho</a>
                            <?php endif; ?>
                         </td>
                    <?php endif; ?>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</section>

<?php if (isset($_GET['status'])): ?>
    <?php if ($_GET['status'] == 'editado'): ?>
        <p>Item editado com sucesso!</p>
    <?php elseif ($_GET['status'] == 'excluido'): ?>
        <p>Item excluído com sucesso!</p>
    <?php endif; ?>
<?php endif; ?>

<?php
if (isset($_SESSION['mensagem'])){
    echo "<p>{$_SESSION['mensagem']}</p>";
    unset($_SESSION['mensagem']);  
}
?>