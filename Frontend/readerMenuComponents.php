<?php
    require_once("util/htmlUtil.php");
    /* --- Reader Home Page Component --- */
    $searchBoxComponentDark = new Component(
        "<div id='searchbox-container' class='container'><div class='row'>".
        "<div class='col-12'><form id='search-form' class='row' method='get' action='./search.php'>".
        "<div class='col-12 col-md-3 col-lg-2'><label for='search-box'>SEARCH</label></div>".
        "<div class='col-10 col-md-7 col-lg-9'><input id='search-box' name='search' type='text' pattern='([^\\x27\\x22])+' placeholder='SEARCH DOCUMENT BY ID, TITLE OR PUBLISHER ID' required/>".
        "<input style='display:none' id='search-type' name='type' type='text' value='Document'/>".
        "</div><div class='col-2 col-md-2 col-lg-1'><button><img src='./images/magnify-glass.svg' alt='City Library | Search'/></button>".
        "</div></form></div></div></div>"
    );

    $searchBoxComponentLight = new Component(
        "<section id='search-container'><div id='searchbox-container' class='container'><div class='row'><div class='col-12'>".
        "<form id='search-form' class='row' method='get' action='./search.php'>".
        "<div class='col-12 col-md-3 col-lg-2'><label for='search-box'>SEARCH</label></div>".
        "<div class='col-10 col-md-7 col-lg-9'><input id='search-box' name='search' type='text' pattern='([^\\x27\\x22])+' placeholder='SEARCH DOCUMENT BY ID, TITLE OR PUBLISHER ID' required/>".
        "<input style='display:none' id='search-type' name='type' type='text' value='Document'/>".
        "</div><div class='col-2 col-md-2 col-lg-1'><button><img src='./images/magnify-glass.svg' alt='City Library | Search'/></button></div></form></div></div></div></section>"
    );


    class ReaderCardType1{ 
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


    $profile_card  = new ReaderCardType1("&#128722;","Reader's Cart","Show list of Books that user wants to Borrow","./cart.php");
    $reserved_card = new ReaderCardType1("R","Reserved List","Show the List of Reserved Document Information","./reserve.php");
    $borrowed_card = new ReaderCardType1("B","Borrowed List","Show the List of Borrowed Document Information","./borrow.php");

    $catalog_card = new ReaderCardType1("C","SHOW CATALOG","List out all the Documents available across all Libraries and Branches","./search.php?type=Document&all=true");
    $help_card    = new ReaderCardType1("?","HELP","This website comes with a manual for using this Library system.","./docs/manual.pdf");


    $commonSubsetMenu = (
        "<section id='reader-submenu-main'><div id='submenu-set-2' class='container h-100'><div class='row  h-100'>".
        "<div class='col-12 col-md h-100'>".$catalog_card->getCode()."</div>".
        "<div class='col-12 col-md h-100'>".$help_card->getCode()."</div>".
        "</div></div></section>"
    );

    $readerPageCode= (
        "<main id='reader'><section id='cover-search'><div id='reader-background'></div>".$searchBoxComponentDark->getCode()."</section>".
        "<section id='tag-line'><div id='reader-tag-line' class='container-fluid'><div class='row'>".
        "<div class='display-none-md col-md-5'><div class='pl-5'><div class='reader-decor-dash'></div>".
        "<div class='reader-decor-dash' style='background-color: black'></div><div class='reader-decor-dash'></div>".
        "</div></div><div class='col-12 col-md-7'><h2>WELCOME TO THE WORLD OF READING</h2></div></div></div></section>".
        "<section id='reader-submenu'><div id='submenu-set' class='container h-100'><div class='row  h-100'>".
        "<div class='col-12 col-md h-100'>".$profile_card->getCode()."</div>".
        "<div class='col-12 col-md h-100'>".$reserved_card->getCode()."</div>".
        "<div class='col-12 col-md h-100'>".$borrowed_card->getCode()."</div>".
        "</div></div></section><div class='hr-grey' style='width: 75%'></div>".
        $commonSubsetMenu."</main>"
    );
    $readerMenuComponents = new Component($readerPageCode);

?>