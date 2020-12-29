<?php
    session_start();
    $error=false;
    if( isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"]){
        $sql = new mysqli("localhost","root","root123","CityLibrary");
        if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
        $query = $sql->prepare("INSERT INTO BORROWS (BorNumber,DocId,CopyNo,BId,ReaderId) VALUES(?,?,?,?,?)");


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
                if ($sql->query("INSERT INTO BOR_TRANSACTION VALUES(NULL,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP() + interval '20' day,0)") === TRUE) {
                    $BorID = ($sql->query("SELECT LAST_INSERT_ID() AS LAST"))->fetch_assoc()['LAST'];
                    
                    $query->bind_param("sssss", $BorID, $result['DocId'], $result['CopyNo'], $result['BId'], $_SESSION['lastCardNumber']);
                    $query->execute();

                    $result = (
                        $sql->query(
                            "SELECT RetDateTime FROM (BOR_TRANSACTION NATURAL JOIN BORROWS) WHERE BorNumber = '$BorID' AND DocId = '".
                            $result['DocId']."' AND CopyNo = '".$result['CopyNo']."' AND BId = '".$result['BId']."' AND ReaderId = '".$_SESSION['lastCardNumber']."'"
                        )->fetch_assoc()
                    )['RetDateTime'];

                    $sql->query("CREATE EVENT CALC_FINE".$BorID." ON SCHEDULE EVERY 1 DAY DO UPDATE BOR_TRANSACTION SET Fine = Fine + 20  WHERE BorNumber = '$BorID' AND CURRENT_TIMESTAMP() > '$result'");
                    echo "Transaction ".$cart["DocId"]." updated...<br>";
                    
                }else{
                    echo "Transaction ".$cart["DocId"]." not added...<br>";
                    $error=true;
                    break;
                }
            }
        }

        
        if($error){
            echo "<strong>Borrow Transaction is partially or completely unsuccessful</strong>, This page will redirect to Cart Page in 10 seconds";
        }else{
            echo "<strong>Borrow Transaction successful</strong>, This page will redirect to Cart Page in 10 seconds";
        }
        header('Refresh: 10; URL=../cart.php');
    }else{
        echo "Access Denied";
    }
?>