<!--
  PROJECT: CS631 - CITY LIBRARY PROJECT 
  PROJECT TEAM: Aarjavi D, Prem K, Rahul Putcha Gautham
-->
<?php
  require_once("util/htmlUtil.php");
  require_once("util/sqlUtil.php");
  require_once("./readerMenuComponents.php");
  session_start();
  
  
  
  if(isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"]){
    if(isset($_SESSION["lastCardNumber"])){
        $cardNumber = $_SESSION["lastCardNumber"];
        $error=false;
    }
  }

  if(!$error)
  {
    $title = "Reserve | Reader: $cardNumber";
    $body = new Body();

    function createReservedInstance($ResNumber,$DocId,$DocName,$PublisherName,$ResDate,$CopyId,$BranchId){
        return (
        "
         <div class='row  text-center m-1 p-4 search-instance' style='text-transform:uppercase;background-color:#e4e4e4'>
            <div style='font-size:1.25rem' class='col-12 col-md-2'>#$ResNumber</div>
            <div style='font-size:1.25rem' class='col-12 col-md-1'>$DocId</div>
            <div class='col-12 col-md-3'>
                <p style='font-size:1.25rem'>$DocName &nbsp;<small>$PublisherName</small></p>
            </div>
            <div class='col-12 col-md-2 p-1'>
                <p style='font-size:1rem'>$ResDate</p>
            </div>
            <div class='col-12 col-md-2 p-1'>
                <a href='./cart/addReserveToBorrow.php?id=$DocId&cid=$CopyId&bid=$BranchId'
                    button style='text-decoration:none;margin-right:20px;padding:10px 20px;border-radius:10px;font-size:1rem' class='button-green'>Borrow
                </a>                
            </div>".   
        "</div>");
    }

    $sql = new SQL();
    $result = $sql->execute("SELECT ResNumber, DocId, Title, PubName, ResDateTime, CopyNo, BId  FROM (RESERVATION NATURAL JOIN RESERVES NATURAL JOIN DOCUMENT NATURAL JOIN PUBLISHER) WHERE ReaderId = ".$_SESSION["lastCardNumber"]);
    $pageComponent = (
        "<main id='borrow'>".$searchBoxComponentLight->getCode()."<div class='hr-grey' style='width:100%'></div><div class='container'>".
        "<div class='row'><div class='col'><h2>Reader's Reserve Page</h2></div></div>"
    );
    if(gettype($result) == "array"){
        if(isset($result[0])){
            $pageComponent .= (
                "<div class='row  text-center m-1 p-4 display-none-md' style='text-transform:uppercase;'>
                    <div class='col-md-2'>ResNumber</div>
                    <div class='col-md-1'>DocId</div>
                    <div class='col-md-3'>Book & Publisher</div>
                    <div class='col-md-2'>Reserved</div>
                 </div>"
            );
            foreach($result as $key => $value){
                $pageComponent .= createReservedInstance($value[0],$value[1],$value[2],$value[3],$value[4],$value[5],$value[6]);
            }
        }else{
            $pageComponent .= (
                "<div class='row  text-center m-1 p-4 display-none-md' style='text-transform:uppercase;'>
                    Empty Reserved Page
                 </div>"
            );
        }
    }else{
        $pageComponent .= (
            "<div class='row  text-center m-1 p-4 display-none-md' style='text-transform:uppercase;'>
                Empty Reserved Page
             </div>"
        );
    }
    $pageComponent .= "</div><div class='hr-grey' style='width:100%'></div>".($commonSubsetMenu)."</main>";

    $html = new HtmlDocument("City Library | $title", $body->getBody($pageComponent));
    $html->setStyle($styleComponent->getCode());
    $html->setScript($scriptComponent->getCode());
    $html->printHTML();
  }else{
    echo "<html><head><title>City Library | 404 Not Found</title></head><body>Access Denied</body><html>";
  }

?>