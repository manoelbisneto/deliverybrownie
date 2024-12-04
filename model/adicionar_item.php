<?php
@session_start();

// Verifica se o usuário está logado e se é um administrador
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'admin') {
    echo "Acesso negado.";
    exit;
}

// Inclui o arquivo de configuração para conexão com o banco de dados
include_once("../configuration/config.inc.php");

// Verifica se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $categoria_id = $_POST['categoria'];
    $disponivel = isset($_POST['disponivel']) ? 1 : 0;

    // Prepara e executa a consulta para inserir o novo item
    $sql = "INSERT INTO itens_menu (nome, descricao, preco, categorias_id, disponivel) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $nome, $descricao, $preco, $categoria_id, $disponivel);

    if ($stmt->execute()) {
        // Redireciona de volta para a página do cardápio com uma mensagem de sucesso
        header("Location: ../index.php?pag=cardapio");
        exit;
    } else {
        echo "Erro ao adicionar item: " . $conn->error;
    }

    // Fecha a declaração
    $stmt->close();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
