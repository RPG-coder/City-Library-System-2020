<?php
    require_once("util/htmlUtil.php");
    require_once("util/sqlUtil.php");
    require_once("readerMenuComponents.php");
    /* --- Search Page --- */

    function getSearchInstance($DocId,$DocName,$PublisherName){//$DocumentType
        //$letter = (strtolower($DocumentType)=="book"?"B":(strtolower($DocumentType)=="journal"?"J":(strtolower($DocumentType)=="conference proceedings"?"CP":"D")));
        $letter = "D";
        return (
            "<div class='row m-1 p-4 search-instance' style='background-color:#e4e4e4'><div class='col-12 col-md-1 col-lg-1'>$DocId</div>".
            "<div class='col-12 col-md-1 col-lg-1'><div class='tag-box'>".$letter."</div>".
            "</div><div class='col-12 col-md-5 col-lg-6' style='text-transform:uppercase'>".
            "<p style='font-size:1.5rem'>'$DocName' &nbsp;<small>$PublisherName</small></p></div><div class='col-12 col-md-5 col-lg-4 text-center'>".
            "<form method='post' action='./viewDocument.php' class='text-center'>".
            "<input style='display:none' type='text' name='doc_id' value='$DocId'/>".
            "<input style='display:none' type='text' name='doc_name' value='$DocName'/>".
            "<input style='display:none' type='text' name='pub_name' value='$PublisherName'/>".
            //"<input style='display:none' type='text' name='doc_type' value='$DocumentType'/>".
            "<button type='submit' style='padding: 10px 20px;border-radius:5px'class='button-green'>CHECK AVAILABILITY</button></form></div></div>"
        );
    }

?>