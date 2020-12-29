<!--
  PROJECT: CS631 - CITY LIBRARY PROJECT 
  PROJECT TEAM: Aarjavi D, Prem K, Rahul Putcha Gautham
-->
<?php
  require_once("util/htmlUtil.php");
  require_once("util/sqlUtil.php");
  require_once("readerMenuComponents.php");
  
  session_start();
  if((isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"])){
    if(isset($_POST["doc_id"])&&isset($_POST["doc_name"])&&
        isset($_POST["pub_name"])){

        $sql = new SQL();

        $title = "View | Document: ".$_POST["doc_name"];
        class DocumentCard{
            private $card;
            function __construct($DocId,$DocName,$Publisher){
                $letter = "D";//= (strtolower($DocumentType)=="book"?"B":(strtolower($DocumentType)=="journal"?"J":"CP"));
                $this->card = (
                    "<div class='doc-card h-100'><div class='row doc-card-head' style=''><div class='col-md-2'></div><div class='col'>".
                    "<div class='doc-card-tag'>".$letter."</div>".
                    "</div><div class='col-md-2'></div></div><div class='row doc-card-body' style='height:48%'>".
                    "<div class='col-4'></div><div class='col' style='text-transform: uppercase'>".
                    "<h2 class='m-0'>$DocName</h2><p class='m-0'>By $Publisher</p><p class='m-0'>DOCUMENT ID: $DocId</p>".
                    "</div><div class='col-4'></div></div></div>"
                );
            }
            function getCode(){
                return $this->card;
            }
        }

        class DocumentInfo{
            private $card;
            function __construct($available){
                $interval    = date_interval_create_from_date_string('20 days');
                $returnDate  = date_add(date_create(date("d-m-Y")), $interval);
                $this->card = (
                    "<div style='margin: 10% 5%;background-color:#e4e4e4' class='doc-info-box p-4'>".
                    (($available)?(
                        "<div class='alert alert-success text-center' role='alert'>The Document is currently available</div>".
                        "<p>Reader checks out on ".date("m-d-Y")." must return the document by ".date_format($returnDate,"m-d-Y")."</p>"
                    ):(
                        "<div class='alert alert-danger text-center' role='alert'>The Document is currently unavailable</div>".
                        "<p>Copies of this Document is not available at this moment of time.</p>"
                    )).
                    (($available)?(
                    "<div class='text-center mt-3'>".
                    "<form style='display:inline-block' method='get' action='./cart/addToCart.php'>".
                    "<input style='display:none' type='text' name='id' value='".$_POST["doc_id"]."' />".
                    "<input style='display:none' type='text' name='name' value='".$_POST["doc_name"]."' />".
                    "<input style='display:none' type='text' name='pub' value='".$_POST["pub_name"]."' />".
                    "<div style='display:none'><span>Copies:</span><input style='margin:1px auto;padding: 2px 10px' class='text-center' type='number' name='copies' value='1' max='10' min='1' /></div><br/>".
                    "<button type='submit' style='padding:10px 20px;border-radius:5px;' class='button-green'>Add to Cart</button></form>".
                    "<a href='./cart.php' style='text-decoration:none;padding:10px 20px;border-radius:5px;' class='bg-secondary text-white ml-4 mr-4'>Go to Cart</a></div>"
                    ):("<div class='text-center mt-3'><a href='./reader.php' style='text-decoration:none;padding:10px 20px;border-radius:5px;' class='button-green'>Go to Home</a></div>")).
                    "</div>"
                );
            }
            function getCode(){
                return $this->card;
            }
        }

        function checkAvailability($DocId){
            $sql = new SQL();
            $result = $sql->execute("SELECT NoOfCopies FROM Copy GROUP BY DocId HAVING DocId = '$DocId'");
            if(gettype($result) == "array"){
                if(isset($result[0]) && $result[0][0] > 0){ //Check First Column of First Row Query result
                    return true;
                }
            }
            return false;
        }

        $leftColumnComponent = new DocumentCard($_POST["doc_id"],$_POST["doc_name"],$_POST["pub_name"]);
        $rightColumnComponent = new DocumentInfo(checkAvailability($_POST["doc_id"]));

        $viewDocumentComponent = new Component(
            "<main id='search-page'>".$searchBoxComponentLight->getCode().
            "<div class='hr-grey' style='width:75%'></div>".
            "<section id='document-view' class='container-fluid'>".
            "<div class='row h-100'><div class='col-12 col-md h-100'>".$leftColumnComponent->getCode()."</div>"."<div class='col-12 col-md h-100'>".
            $rightColumnComponent->getCode()."</div></div></section>"."<div class='hr-grey' style='width: 75%'></div>".$commonSubsetMenu."</main>"
        );

        $body = new Body();
        $html = new HtmlDocument("City Library | $title", $body->getBody($viewDocumentComponent->getCode()));
        $html->setStyle($styleComponent->getCode());
        $html->setScript($scriptComponent->getCode());
        $html->printHTML();
    }else{
        $html = new HtmlDocument("City Library | 404 Not Found", "404 Not Found");
        $html->printHTML();
    }
  }else{
    $html = new HtmlDocument("City Library | 404 Not Found", "404 Not Found");
    $html->printHTML();
  }

?>