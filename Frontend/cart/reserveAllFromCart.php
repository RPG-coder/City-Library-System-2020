<?php
    require_once("../util/sqlUtil.php");
    session_start();
    
    $error = false;

    if(isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"]){
        $sql = new mysqli("localhost","root","root123","CityLibrary");
        if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}

        $query = $sql->prepare("INSERT INTO RESERVES (ResNumber,DocId,CopyNo,BId,ReaderId) VALUES(?,?,?,?,?)");
        foreach($_SESSION['cart'] as $key=>$value){    
            $cart = (new ArrayObject($value))->getArrayCopy();
            if(isset($_SESSION['cart'][$key])) unset($_SESSION['cart'][$key]);
            
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
                    echo "Transaction ".$cart["DocId"]." added...<br>";
                }else{
                    echo "Transaction ".$cart["DocId"]." not added...<br>";
                    $error=true;
                    break;
                }
            }
        }
        
        if($error){
            echo "<strong>Reservation is partially or completely unsuccessful</strong>, This page will redirect to Cart Page in 10 seconds";
        }else{
            echo "<strong>All Reservation are successfully completed</strong>, This page will redirect to Cart Page in 10 seconds";
        }
        header('Refresh: 10; URL=../cart.php');
    }else{
        echo "Access Denied";
    }

?>