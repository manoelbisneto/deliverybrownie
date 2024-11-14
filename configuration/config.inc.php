<?php
$conn = mysqli_connect("127.0.0.1", "root", "");

if (!$conn) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
} else {
    echo "Conexão estabelecida com sucesso";
}

$db = mysqli_select_db($conn, "delivery_db");
if (!$db) {
    die("Erro na seleção do banco de dados: " . mysqli_error($conn));
}
?>