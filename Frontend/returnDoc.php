<?php
  session_start();
  echo isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"];
  if(isset($_SESSION["reader_logged"]) && $_SESSION["reader_logged"] && 
    isset($_GET['bor']) && isset($_GET['did']) && isset($_GET['copy']) && isset($_GET['bid'])){
    $sql = new mysqli("localhost","root","root123","CityLibrary");
    if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
  
    if(
        $sql->query(
            "DELETE FROM BORROWS WHERE BorNumber = ".$_GET['bor'].
            " AND CopyNo=".$_GET['copy']." AND BId = ".$_GET['bid']." AND DocId = ".$_GET['did']
        ) === TRUE
    ){
        echo "Document Returned. This Page is reloaded to HOME in 10 Sec";
        
    }else{
        echo "ERROR IN RETURNING!!. This Page is reloaded to HOME 10 Sec";
    }
    header('Refresh: 10; URL=./reader.php');
  }else{
    echo "Access Denied";
  }
?>