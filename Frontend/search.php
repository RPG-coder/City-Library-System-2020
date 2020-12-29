<!--
  PROJECT: CS631 - CITY LIBRARY PROJECT 
  PROJECT TEAM: Aarjavi D, Prem K, Rahul Putcha Gautham
-->
<?php
  session_start();
  $isAdmin = false;  
  if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){ $isAdmin = true; }
  require_once("util/htmlUtil.php");
  require("searchPageComponents.php");

  

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
      
    $searchResult = getSearchInstance("A1B2C3","Harry Potter","Bloomsbury Publishing","Journal").
    getSearchInstance("A1B2C3","Harry Potter","Bloomsbury Publishing","Book").
    getSearchInstance("A1B2C3","Harry Potter","Bloomsbury Publishing","conference proceeding");
    
    $searchPageComponent = new Component(
        "<main id='search-page'>".$searchBoxComponentLight->getCode().
        "<section id='search-results'><div id='search-result-container' class='container h-100'>".
            "<div class='hr-grey' style='width:100%'></div>".
            "<div class='row'><div class='col p-3'>SEARCH RESULTS</div></div>".
            "<div class='row h-100 pt-5 pb-5'><div class='col h-100'>".
            //SQL Table in form of Search Instance Here...
            (($searchResult!=null)?$searchResult:"<p class='m-1 p-4 text-center bg-light'>No Results</p>").
        "</div></div></div></section><div class='hr-grey' style='width: 75%'></div>".$commonSubsetMenu."</main>"
    );
      $sql = new SQL();
      $searchResult = "";
      if(isset($_GET["all"])&&$_GET["all"]=="true"){
        $result = $sql->execute("SELECT DocId,Title,PubName FROM DOCUMENT AS D,PUBLISHER AS P WHERE D.PublisherId=P.PublisherId");
      }else{
        $result = $sql->execute("SELECT DocId,Title,PubName FROM DOCUMENT AS D,PUBLISHER AS P WHERE D.PublisherId=P.PublisherId AND ( PubName like '%".$_GET["search"]."%' OR Title like '%".$_GET["search"]."%' OR DocId like '%".$_GET["search"]."%')");
      }

      foreach($result as $value){
        $searchResult .= getSearchInstance($value[0],$value[1],$value[2]);
      }
      
      $searchPageComponent = new Component(
          "<main id='search-page'>".$searchBoxComponentLight->getCode().
          "<section id='search-results'><div id='search-result-container' class='container h-100'>".
              "<div class='hr-grey' style='width:100%'></div>".
              "<div class='row'><div class='col p-3'>SEARCH RESULTS</div></div>".
              "<div class='row h-100 pt-5 pb-5'><div class='col h-100'>".
              //SQL Table in form of Search Instance Here...
              (($searchResult)?$searchResult:"<p class='m-1 p-4 text-center bg-light'>No Results</p>").
          "</div></div></div></section><div class='hr-grey' style='width: 75%'></div>".$commonSubsetMenu."</main>"
      );

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