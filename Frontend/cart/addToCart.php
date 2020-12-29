<?php
    session_start();
    if(isset($_SESSION["cart"])&&isset($_GET["id"])&&isset($_GET["name"])&&isset($_GET["pub"])&&isset($_GET["copies"])){
        $_SESSION["cartId"] = $_SESSION["cartId"] + 1;
        array_push(
            $_SESSION["cart"],
            array($_SESSION["cartId"], "DocId"=>$_GET["id"], "DocName"=>$_GET["name"], "PublisherName"=>$_GET["pub"],"NumberOfCopies"=>$_GET["copies"])
        );
    }
    header("Location: ../cart.php");
?>