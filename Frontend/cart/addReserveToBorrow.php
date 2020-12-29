<?php
    require_once("../util/sqlUtil.php");
    session_start();
    if(isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"] && isset($_GET["id"]) && isset($_GET["cid"]) && isset($_GET["bid"])){
        $sql = new SQL();
        $sql1 = new mysqli("localhost","root","root123","CityLibrary");
        $sql1->query("INSERT INTO BOR_TRANSACTION VALUES(NULL,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP() + interval '20' day,0)");
        $sql->execute("DELETE FROM RESERVES WHERE DocId='".$_GET["id"]."' AND CopyNo='".$_GET["cid"]."' AND BId='".$_GET["bid"]."' AND ReaderId = '".$_SESSION['lastCardNumber']."'");
        $BorID = ($sql1->query("SELECT LAST_INSERT_ID() AS LAST")->fetch_assoc())['LAST'];
        
        $query = $sql1->prepare("INSERT INTO BORROWS (BorNumber,DocId,CopyNo,BId,ReaderId) VALUES(?,?,?,?,?)");
        $query->bind_param("sssss", $BorID, $_GET["id"], $_GET["cid"], $_GET["bid"], $_SESSION['lastCardNumber']);
        $query->execute();
        $result = (
            $sql1->query(
                "SELECT RetDateTime FROM (BOR_TRANSACTION NATURAL JOIN BORROWS) WHERE BorNumber = '$BorID' AND DocId = '".
                $_GET["id"]."' AND CopyNo = '".$_GET["cid"]."' AND BId = '".$_GET["bid"]."' AND ReaderId = '".$_SESSION['lastCardNumber']."'"
            )->fetch_assoc()
        )['RetDateTime'];

        $sql1->query("CREATE EVENT CALC_FINE".$BorID." ON SCHEDULE EVERY 1 DAY DO UPDATE BOR_TRANSACTION SET Fine = Fine + 20  WHERE BorNumber = '$BorID' AND CURRENT_TIMESTAMP() > '$result'");
        echo "<strong>Borrow Transaction successful</strong>, This page will redirect to Cart Page in 10 seconds";
        
    }else{
        echo "Access Denied";
    }
    header("Refresh: 10; URL=../reserve.php");
?>