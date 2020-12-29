<?php
  require_once("util/htmlUtil.php");
  $searchDocumentComponentDark = (
    "<div id='searchbox-container' class='container'><div class='row'>".
    "<div class='col-12'><form id='search-form' class='row' method='get' action='./adminSearch.php'>".
    "<div class='col-12 col-md-3 col-lg-2'><label for='search-box'>SEARCH</label></div>".
    "<div class='col-10 col-md-7 col-lg-9'><input id='search-box' name='search' type='text' pattern='([^\\x27\\x22])+' placeholder='SEARCH DOCUMENT COPY...' required/>".
    "<input style='display:none' id='search-type' name='type' type='text' value='Copy'/>".
    "</div><div class='col-2 col-md-2 col-lg-1'><button><img src='./images/magnify-glass.svg' alt='City Library | Search'/></button>".
    "</div></form></div></div></div>"
  );

  $searchBoxComponentLight = new Component(
    "<section id='search-container'><div id='searchbox-container' class='container'><div class='row'><div class='col-12'>".
    "<form id='search-form' class='row' method='get' action='./adminSearch.php'>".
    "<div class='col-12 col-md-3 col-lg-2'><label for='search-box'>SEARCH</label></div>".
    "<div class='col-10 col-md-7 col-lg-9'><input id='search-box' name='search' type='text' pattern='([^\\x27\\x22])+' placeholder='SEARCH DOCUMENT COPY...' required/>".
    "<input style='display:none' id='search-type' name='type' type='text' value='Copy'/>".
    "</div><div class='col-2 col-md-2 col-lg-1'><button><img src='./images/magnify-glass.svg' alt='City Library | Search'/></button></div></form></div></div></div></section>"
  );

  class AdminCard{ 
    private $TagLetter, $CardTitle, $CardBody,$Link;
    function __construct($tagLetter,$cardTitle,$cardBody, $onClickLink){
        $this->TagLetter = $tagLetter;
        $this->CardTitle = $cardTitle;
        $this->CardBody = $cardBody;
        $this->Link = $onClickLink;
    }
    function getCode(){
        return (
            "<div class='row p-4 h-100'><div class='col submenu-card h-90'><div><div class='submenu-card-head'>".
            "<div>".$this->TagLetter."</div></div><div class='submenu-card-body'><div class='text-center p-4'>".
            "<h3 class='m-1'>".$this->CardTitle."</h3><p class='p-2 text-body'>".$this->CardBody."</p>".
            "<a href='".$this->Link."' style='text-decoration:none;'><button class='button-black'>SHOW</button></div></div></div></div></div></a>"
        );
    }
  }
  $addDocumentCard = new AdminCard("+","Add Document Copy","Adds new Document Copy to the City Library Collection", "./addDocument.php");
  $PrintBranchInfoCard = new AdminCard("P","Show Branches","Prints all Branch Information by Name and Location", "./adminSearch.php?type=Branch&all=true");
  $addReaderCard = new AdminCard("+","Add Readers","Register a new Reader in the City Library Database", "./addReader.php");
  $commonSubsetMenu = (
    "<section id='reader-submenu'><div id='submenu-set' class='container h-100'><div class='row  h-100'>".
    "<div class='col-12 col-md h-100'>".$addReaderCard->getCode()."</div>".
    "<div class='col-12 col-md h-100'>".$PrintBranchInfoCard->getCode()."</div>".
    "<div class='col-12 col-md h-100'>".$addDocumentCard->getCode()."</div>".
    "</div></div></section><div class='hr-grey' style='width: 75%'></div>"
  );
  $adminMenuComponents = new Component(
    "<main id='admin'><section id='cover-search'><div id='admin-background'></div>".$searchDocumentComponentDark."</section>".
    "<section id='tag-line'><div id='reader-tag-line' class='container-fluid'><div class='row'>".
    "<div class='display-none-md col-md-5'><div class='pl-5'><div class='reader-decor-dash'></div>".
    "<div class='reader-decor-dash' style='background-color: black'></div><div class='reader-decor-dash'></div>".
    "</div></div><div class='col-12 col-md-7'><h2>WELCOME TO THE WORLD OF READING</h2></div></div></div></section>".
    $commonSubsetMenu."<div class='text-center m-4'><a style='font-size:2rem' href='./getQueries.php'>Queries <small>New!!</a></small></div>".
    "</main>"
  );
?>