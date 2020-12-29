<?php
    require_once("../util/sqlUtil.php");
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
            if ($sql->query("INSERT INTO BOR_TRANSACTION VALUES(NULL,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP() + interval '20' day,0)") === TRUE) {
                $BorID = ($sql->query("SELECT LAST_INSERT_ID() AS LAST"))->fetch_assoc()['LAST'];
                $query = $sql->prepare("INSERT INTO BORROWS (BorNumber,DocId,CopyNo,BId,ReaderId) VALUES(?,?,?,?,?)");
                $query->bind_param("sssss", $BorID, $result['DocId'], $result['CopyNo'], $result['BId'], $_SESSION['lastCardNumber']);
                $query->execute();

                $result = (
                    $sql->query(
                        "SELECT RetDateTime FROM (BOR_TRANSACTION NATURAL JOIN BORROWS) WHERE BorNumber = '$BorID' AND DocId = '".
                        $result['DocId']."' AND CopyNo = '".$result['CopyNo']."' AND BId = '".$result['BId']."' AND ReaderId = '".$_SESSION['lastCardNumber']."'"
                    )->fetch_assoc()
                )['RetDateTime'];

                $sql->query("CREATE EVENT CALC_FINE".$BorID." ON SCHEDULE EVERY 1 DAY DO UPDATE BOR_TRANSACTION SET Fine = Fine + 20  WHERE BorNumber = '$BorID' AND CURRENT_TIMESTAMP() > '$result'");
                echo "<strong>Borrow Transaction successful</strong>, This page will redirect to Cart Page in 10 seconds";
                header('Refresh: 10; URL=../cart.php');
                echo "Transaction updated...<br>";
            }else{
                echo "Transaction not added...<br>";
            }
        }
    }else{
        echo "Access Denied";
    }
?>