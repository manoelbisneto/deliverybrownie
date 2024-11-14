<?php
include_once("../configuration/config.inc.php");

    $nome = $_REQUEST['nome'];
    $email = $_REQUEST['email'];
    $senha = password_hash($_REQUEST['senha'], PASSWORD_DEFAULT); // Criptografa a senha
    $tipo = $_REQUEST['tipo']; 

    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) 
            VALUES ('$nome', '$email', '$senha', '$tipo')";

    // Executa a query
    if (mysqli_query($conn, $sql)) {
        echo "Usuário cadastrado com sucesso!";
    } else {
        echo "Erro: " . mysqli_error($conn);
    }

    // Fecha conexão
    mysqli_close($conn);
    header("Location: ../index.php");

?>