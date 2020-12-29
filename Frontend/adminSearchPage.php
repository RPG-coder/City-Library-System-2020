<?php
    require_once("util/htmlUtil.php");
    require_once("util/sqlUtil.php");
    require_once("adminMenuComponents.php");
    /* --- Search Page --- */

    

    class Search{
        private $type, $filter;
        public function __construct($type, $filter){
            $this->type   = $type;
            $this->filter = $filter; //for get All: filter==null
            
        }
        public function getCode(){
            $searchResult = $this->getInstances();
            global $searchBoxComponentLight, $commonSubsetMenu;
            return (new Component(
                "<main id='search-page'>".$searchBoxComponentLight->getCode().
                "<section id='search-results'><div id='search-result-container' class='container h-100'>".
                    "<div class='hr-grey' style='width:100%'></div>".
                    "<div class='row'><div class='col p-3'>SEARCH RESULTS</div></div>".
                    "<div class='row h-100 pt-5 pb-5'><div class='col h-100'>".
                    (($searchResult!=null)?$searchResult:"<p class='m-1 p-4 text-center bg-light'>No Results</p>").
                "</div></div></div></section><div class='hr-grey' style='width: 75%'></div>".$commonSubsetMenu."</main>"
            ));
        }

        private function getInstances(){
            $sql = new SQL();
            $searchResult="";
            $result = array();
            if($this->type==="Branch"){
                if($this->filter){
                    $result = $sql->execute("SELECT BId, Name, Location FROM BRANCH WHERE BId like '".$this->filter."' OR Name like'".$this->filter."' OR Location like '".$this->filter."'");
                }else{$result = $sql->execute("SELECT BId, Name, Location FROM BRANCH");}
                foreach($result as $key=>$value) {$searchResult .= $this->getBranchInstance($value[0],$value[1],$value[2]);}
            }else if($this->type==="Copy"){
                
                if($this->filter){
                    $result = $sql->execute(
                        "SELECT DISTINCT DocId, CopyNo, Title, PubName, Position, Name, Location FROM (BRANCH NATURAL JOIN COPY NATURAL JOIN DOCUMENT NATRUAL JOIN PUBLISHER) WHERE DocId like '%".
                        $this->filter."%' OR Title like '%".$this->filter."%'"
                    );
                }else{
                    $result = $sql->execute(
                        "SELECT DISTINCT DocId, CopyNo, Title, PubName, Position, Name, Location FROM (BRANCH NATURAL JOIN COPY NATURAL JOIN DOCUMENT NATRUAL JOIN PUBLISHER)"
                    );
                }
                foreach($result as $key=>$value) {
                    $searchResult .= $this->getCopyInstance($value[0],$value[1],$value[2],$value[3],$value[4],$value[5],$value[6]);
                }
                
                return ($searchResult);
            }else{
                return null;
            }
            
            return ($searchResult);
        }
        
        private function getCopyInstance($DocId, $CopyNo, $DocName, $PublisherName, $Position, $BName, $Location) {
            return (
                "<div class='row m-1 p-4 search-instance' style='background-color:#e4e4e4'>".
                  "<div class='col-12 col-md-2 col-lg-2'>DocumentId: $DocId</div>".
                  "<div class='col-12 col-md-2 col-lg-2'>CopyNo: $CopyNo</div>".
                  "<div class='col-12' style='text-transform:uppercase'>".
                    "<p style='font-size:1.5rem'>$DocName By <small>$PublisherName</small></p>".
                    "<p style='font-size:1.5rem'>Position : $Position <br/> stored in the $BName, $Location Branch</p>".
                  "</div>".
                "</div>"
            );
        }

        private function getBranchInstance($BId,$BName,$Location) {
            return (
                "<div class='row m-1 p-4 search-instance' style='background-color:#e4e4e4'>".
                  "<div class='col-12 col-md-1 col-lg-1'>$BId</div>".
                  "<div class='col-12 col-md-5 col-lg-6' style='text-transform:uppercase'>".
                    "<p style='font-size:1.5rem'>'$BName' &nbsp;<small>$Location</small></p>".
                  "</div>".
                "</div>"
            );
        }
    }

    $searchPageComponent = (isset($_GET["type"]))?(
        ((isset($_GET["all"]))?((new Search($_GET["type"],null))->getCode()):((new Search($_GET["type"],$_GET["search"]))->getCode()))
    ):"";

?>