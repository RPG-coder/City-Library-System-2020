<?php 
    session_start();
    if(isset($_GET["cartId"])&&isset($_SESSION["cart"][$_GET["cartId"]]))
    unset(($_SESSION["cart"])[$_GET["cartId"]]);
    header("Location: ../cart.php");
?>