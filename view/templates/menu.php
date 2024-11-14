<nav>
    <?php if (isset($_SESSION['usuario_logado'])): ?>
        <!-- Se o usuário estiver logado -->
        <a href="?pag=principal">Página Inicial</a> | 
        <?php if ($_SESSION['tipo'] === 'admin'): ?>
            <a href="?pag=pedidos">Pedidos Feitos</a> | 
            <a href="?pag=cadastro_form">Cadastro</a> | 
        <?php else: ?>
            <a href="?pag=cardapio">Cardápio</a> | 
            <a href="?pag=carrinho">Carrinho</a> | 
        <?php endif; ?>
        <a href="view/logout.php">Sair</a>
    <?php else: ?>
        <!-- Se o usuário NÃO estiver logado -->
        <a href="view/login.php">Login</a>
    <?php endif; ?>
</nav>