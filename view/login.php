<?php

@session_start();
// Se já estiver logado, redireciona para a página principal
if (isset($_SESSION['usuario_logado'])) {
    header("Location: ../index.php");
    exit;
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inclui o arquivo de conexão com o banco
    include_once("../configuration/config.inc.php");

    // Recebe os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Consulta para verificar as credenciais
    $sql = "SELECT * FROM usuarios WHERE email = ?";

    // Prepara a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Se houver um usuário com o email fornecido
    if ($result->num_rows > 0) {
        // Recupera os dados do usuário
        $user = $result->fetch_assoc();

        // Verifica se a senha fornecida corresponde à senha armazenada
        if (password_verify($senha, $user['senha'])) {
            // Inicia a sessão e armazena as informações do usuário
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario_logado'] = $user['nome'];
            $_SESSION['tipo'] = $user['tipo']; // Armazena o tipo de usuário (admin ou usuário)

            // Redireciona para a página principal
            header("Location: ../index.php");
            exit;
        } else {
            // Caso as credenciais estejam incorretas
            echo "Email ou senha incorretos!";
        }
    } else {
        // Caso o email não seja encontrado no banco
        echo "Email ou senha incorretos!";
    }
}

?>
<form method="POST" action="view/login.php">
    <label for="email">Email:</label>
    <input type="email" name="email" id="email" required><br><br>

    <label for="senha">Senha:</label>
    <input type="password" name="senha" id="senha" required><br><br>

    <button type="submit">Entrar</button>
</form>
    <a href="?pag=cadastro_form" class="btn btn-primary">Cadastrar</a>

<?php
?>