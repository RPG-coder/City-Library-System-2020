<?php
    session_start();
    if(isset($_SESSION["cart"])&&isset($_GET["id"])){
        $_SESSION["cartId"] = $_SESSION["cartId"] + 1;
        array_push(
            $_SESSION["cart"],
            array($_SESSION["cartId"], "DocId"=>$_GET["id"])
        );
    }
    header("Location: ../reserveFromCart.php?cartId=".$_SESSION["cartId"]);
?>