<?php
@session_start();

@$is_admin = $_SESSION['tipo'] === 'admin';
?>

<form action="model\cadastro_usuario.php" method="POST">
    <label for="nome">Nome:</label>
    <input type="text" name="nome" id="nome" required>

    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required>

    <label for="endereco">Endereço:</label>
    <input type="text" name="endereco" id="endereco" required>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required>

    <label for="confirmar_senha">Confirmar Senha:</label>
    <input type="password" name="confirmar_senha" id="confirmar_senha" required>

    <label for="tipo">Tipo:</label>
    <select name="tipo" id="tipo" required>
        <?php if ($is_admin): ?>
            <option value="admin">Admin</option>
            <option value="usuario">Usuário</option>
        <?php else: ?>
            <option value="usuario" selected>Usuário</option>
        <?php endif; ?>
    </select>

    <button type="submit">Cadastrar</button>
</form>

<script>
    document.querySelector('form').addEventListener('submit', function(event) {
        var senha = document.getElementById('senha').value;
        var confirmarSenha = document.getElementById('confirmar_senha').value;
        
        if (senha !== confirmarSenha) {
            alert('As senhas não coincidem!');
            event.preventDefault(); // Impede o envio do formulário
        }
    });
</script>