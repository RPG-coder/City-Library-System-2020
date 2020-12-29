<!--
  PROJECT: CS631 - CITY LIBRARY PROJECT 
  PROJECT TEAM: Aarjavi D, Prem K, Rahul Putcha Gautham
-->
<?php
  require_once("util/htmlUtil.php");
  require_once("util/sqlUtil.php");
  require("readerMenuComponents.php");
  session_start();
  
  $error=true;
  if(isset($_POST["card_number"]) || isset($_SESSION["lastCardNumber"])){
      #Reader's Card Number
      $cardNumber = isset($_POST["card_number"])?$_POST["card_number"]:$_SESSION["lastCardNumber"];
      $_SESSION["lastCardNumber"] = $cardNumber;
      $sql = new SQL();
      if(gettype($result = $sql->execute("SELECT * FROM READER WHERE ReaderId='$cardNumber'"))=="array"){
        if(sizeof($result)>0){
          $_SESSION["reader_logged"] = true;
          $error = false;
        }
      }
  }else{
    if(isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"]){
      if(isset($_SESSION["lastCardNumber"])){
        $cardNumber = $_SESSION["lastCardNumber"];
        $error=false;
      }
    }
  }
  
  if(!$error)
  {
    if(!isset($_SESSION["cart"])){
      $_SESSION["cart"] = array();
      $_SESSION["cartId"] = 0;
    }

    $title = "Reader: $cardNumber";
    $body = new Body();
    $html = new HtmlDocument("City Library | $title", $body->getBody($readerMenuComponents->getCode()));
    $html->setStyle($styleComponent->getCode());
    $html->setScript($scriptComponent->getCode());
    $html->printHTML();

  }else{
    echo "<html><head><title>City Library | 404 Not Found</title></head><body>404 Not Found</body><html>";
  }

?>