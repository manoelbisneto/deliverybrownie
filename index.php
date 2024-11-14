<?php
include_once("view/templates/topo.php");
include_once("view/templates/menu.php");

if(empty($_SERVER["QUERY_STRING"])){

    $var = "view/principal.php";
    include_once("$var");
}else{
    $pag = $_GET['pag'];
    include_once("view/$pag.php");
}

include_once("view/templates/rodape.php");
?>