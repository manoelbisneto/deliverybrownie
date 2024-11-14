<?php
session_start(); 

$_SESSION['tipo'] = 'admin';

?>

<nav>
    <a href="?pag=principal">Página Inicial</a> | 
    <?php if ($_SESSION['tipo'] === 'admin'): ?>
        <a href="?pag=pedidos">Pedidos Feitos</a> | 
        <a href="?pag=cardapio">Cardápio</a> | 
    <?php else: ?>
        <a href="?pag=carrinho">Carrinho</a> | 
    <?php endif; ?>
    <a href="?pag=cadastro_form">Cadastro</a> | 
    <a href="?pag=sair">Sair</a>
</nav>