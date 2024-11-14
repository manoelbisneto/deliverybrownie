<?php
include_once("templates/topo.php");
include_once("templates/menu.php");

if(empty($_SERVER["QUERY_STRING"])){

    $var = "principal.php";
    include_once("$var");
}else{
    $pag = $_GET['pag'];
    include_once("$pag.php");
}

include_once("templates/rodape.php");
?>