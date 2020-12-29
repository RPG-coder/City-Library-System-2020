<?php
    session_start();
    
    if(isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"] && isset($_GET['cartId']) && isset($_SESSION['cart'][$_GET['cartId']])){
        $sql = new mysqli("localhost","root","root123","CityLibrary");
        if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
        
        $cart = (new ArrayObject($_SESSION['cart'][$_GET['cartId']]))->getArrayCopy();
        if(isset($_SESSION['cart'][$_GET['cartId']])) unset($_SESSION['cart'][$_GET['cartId']]);
        
        $result = $sql->query(
            "SELECT DocId, CopyNo, BId From Copy WHERE DocId='".$cart["DocId"].
            "' AND (DocId, CopyNo, BId) NOT IN (SELECT DocId, CopyNo, BId From BORROWS) ".
            "AND (DocId, CopyNo, BId) NOT IN (SELECT DocId, CopyNo, BId From RESERVES)"
        );
        if($result->num_rows > 0){
            $result = $result->fetch_assoc();
            if ($sql->query("INSERT INTO RESERVATION VALUES(NULL,CURRENT_TIMESTAMP())") === TRUE) {
                $ResID = ($sql->query("SELECT LAST_INSERT_ID() AS LAST"))->fetch_assoc()['LAST'];
                $query = $sql->prepare("INSERT INTO RESERVES (ResNumber,DocId,CopyNo,BId,ReaderId) VALUES(?,?,?,?,?)");
                $query->bind_param("sssss", $ResID, $result['DocId'], $result['CopyNo'], $result['BId'], $_SESSION['lastCardNumber']);
                $query->execute();
                echo "<strong>Reservation successful</strong>, This page will redirect to Cart Page in 10 seconds";
                header('Refresh: 10; URL=../cart.php');
            }else{
                echo "Transaction not added...<br>";
            }
        }
    }else{
        echo "Access Denied";
    }
?>