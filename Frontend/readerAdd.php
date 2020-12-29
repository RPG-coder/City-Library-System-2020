<?php
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];
            if(isset($_POST['rname'])&&isset($_POST['rphone'])){
                $sql = new mysqli("localhost","root","root123","CityLibrary");
                if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
                
                $type = (isset($_POST['rtype'])?$_POST['rtype']:"NormalReader");
                $address = (isset($_POST['raddress'])?$_POST['raddress']:"No Addresss");
                $query = $sql->prepare("INSERT INTO READER (Type,ReaderName,PhoneNo,Address) VALUES(?,?,?,?)");
                $query->bind_param(
                    "ssss", $type, $_POST['rname'], $_POST['rphone'], $address
                );
                $query->execute();
                $cardNo = ($sql->query("SELECT LAST_INSERT_ID() AS LAST")->fetch_assoc())['LAST'];
                echo "Reader CardNo:".$cardNo;
                echo "<br>Reader has been Added";
            }else{
                echo "Reader Details Missing, Please Enter";
            }
            echo "<br>The Page is going to reload in 13 seconds";
            header('Refresh: 13; URL=./addReader.php');
        }
    }else{
        echo "Access Denied";
    }
?>