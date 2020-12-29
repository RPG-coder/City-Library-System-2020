<?php
    $isAdmin = true;
    require_once("util/htmlUtil.php");
    require_once("util/sqlUtil.php");
    require("adminMenuComponents.php");
    session_start();
    $error=true; $admin = null; $password=null;
    if(!(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"])){
      //Authenticating Admin
      if(isset($_POST["admin"]) && isset($_POST["password"])){
        $admin = $_POST["admin"]; $password = $_POST["password"];
        $sql = new SQL();
        if(gettype($result = $sql->execute("SELECT * FROM ADMIN WHERE Id='$admin' AND Password='$password'"))=="array"){
          if(sizeof($result)>0){
            $_SESSION["admin"] = $admin; $_SESSION["password"] = $password; $_SESSION["admin_logged"] = true;
            $error = false;
          }
        }
      }
    }else{
      if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
        $admin = $_SESSION["admin"]; $password = $_SESSION["password"]; $error = false;
        $_SESSION["admin_logged"] = true;
      }
    }
    
    if(!$error)
    {
      $title = "Admin: $admin"; $body = new Body();
      $html = new HtmlDocument("City Library | $title", $body->getBody($adminMenuComponents->getCode()));
      $html->setStyle($styleComponent->getCode()); $html->setScript($scriptComponent->getCode());
      $html->printHTML();
    }else{
      echo "<html><head><title>City Library | Access Denied</title></head><body>Access Denied</body><html>";
    }
?>