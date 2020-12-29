<!--
  PROJECT: CS631 - CITY LIBRARY PROJECT 
  PROJECT TEAM: Aarjavi D, Prem K, Rahul Putcha Gautham
-->
<?php
  $isAdmin = true;  
  require_once("util/htmlUtil.php");
  require("adminSearchPage.php");
  
  session_start();
  $error = false;
  if((isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"]) || 
     (isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"])){
    if(isset($_GET["type"])){
      if(isset($_GET["search"])){
          $title = "SEARCH | ".$_GET["type"].": ".$_GET["search"];
      }else if(isset($_GET["all"])&&$_GET["all"]=="true"){
          $title = "SEARCH | All ".$_GET["type"];
      }else{$error = true;}
    }else{$error = true;}

    if(!$error){
      $body = new Body();
      $html = new HtmlDocument("City Library | $title", $body->getBody($searchPageComponent->getCode()));
      $html->setStyle($styleComponent->getCode());
      $html->setScript($scriptComponent->getCode());
      $html->printHTML();
    }else{
      $html = new HtmlDocument("City Library | 404 Not Found", "404 Not Found");
      $html->printHTML();
    }
  }else{
    $html = new HtmlDocument("City Library | SEARCH", "Access Denied");
    $html->printHTML();
  }
?>