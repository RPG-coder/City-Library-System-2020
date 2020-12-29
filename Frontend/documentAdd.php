<?php
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];
            if(
                isset($_POST['dname'])&&isset($_POST['pdate'])&&isset($_POST['position'])
                &&isset($_POST['pubname'])&&isset($_POST['pubaddress'])&&isset($_POST['bid'])
            ){
                $sql = new mysqli("localhost","root","root123","CityLibrary");
                if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
                
                $query = $sql->prepare("INSERT INTO PUBLISHER (PubName, Address) VALUES(?,?)");
                $query->bind_param("ss", $_POST['pubname'],$_POST['pubaddress']);
                $query->execute();

                $Pid = ($sql->query("SELECT LAST_INSERT_ID() AS LAST"))->fetch_assoc()['LAST'];
                $query = $sql->prepare("INSERT INTO DOCUMENT (Title, PDate, PublisherId) VALUES(?,?,?)");
                $query->bind_param("sss", $_POST['dname'],$_POST['pdate'],$Pid);
                $query->execute();

                $Did = ($sql->query("SELECT LAST_INSERT_ID() AS LAST"))->fetch_assoc()['LAST'];
                echo "Inserted Document ".$Did."<br>";
                
                if($sql->query("INSERT INTO `copy` ( `CopyNo`, `DocId`, `BId`, `Position` )SELECT MAX( `CopyNo` ) + 1, ".$Did.", ".$_POST['bid'].", '".$_POST['position']."' FROM `copy`")===TRUE){
                    echo "COPY ADDED TO DB";
                }else{
                    echo "COPY NOT ADDED";
                }
            }else{
                echo "Reader Details Missing, Please Enter";
            }
            echo "<br>The Page is going to reload in 10 seconds";
            header('Refresh: 10; URL=./addDocument.php');
        }
    }else{
        echo "Access Denied";
    }
?>