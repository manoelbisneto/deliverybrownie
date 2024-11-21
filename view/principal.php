<?php


// // Se o usuário não estiver logado, redireciona para o login
// if (!isset($_SESSION['usuario_logado'])) {
//     header("Location: view/login.php");
//     exit;
// }

// Exibe um conteúdo personalizado para o usuário logado
if (isset($_SESSION['usuario_logado'])) {
    echo "<h2>Bem-vindo, " . $_SESSION['usuario_logado'] . "!</h2>";
}
?>

<h1>Brownie do Mano</h1>

<h3>Quem Somos</h3>
<p>
Somos uma confeitaria apaixonada por criar momentos doces e inesquecíveis. Especializada em brownies artesanais, 
nossos produtos são feitos com ingredientes de alta qualidade, combinando sabor, textura e criatividade. Aqui, cada 
pedaço é um convite para celebrar as pequenas e grandes alegrias da vida. 

</p>
<br>
<h3>Nossa Missão</h3>
<p>
Encantar nossos clientes com brownies artesanais de excelência, proporcionando experiências únicas
 por meio de sabores marcantes e um atendimento acolhedor, sempre valorizando a qualidade,
  a paixão pela confeitaria e a felicidade em cada mordida.
</p>