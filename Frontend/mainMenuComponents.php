<?php
  require_once("util/htmlUtil.php");
  
  class MenuCard{
    private $cardBody;
    function __construct($cardTitle, $cardBody, $formLink){
        $this->cardBody = new Component(
            "<div class='login-card'><h2 style='text-indent: 9px'>".$cardTitle."</h2>".
            "<div class='hr-grey'></div><form method='post' action='$formLink' style='padding:9px'>".
            $cardBody."</form></div>"
        );
    }
    function getCode(){return ($this->cardBody)->getCode();}
  }

  $readerCard = new MenuCard("For Readers", 
    "<div style='padding-top: 25px'><label for='card-number'>Card Number</label>".
    "<input type='text' pattern='[a-zA-Z0-9 ]+' id='card-number' name='card_number' placeholder='Card Number...' required/></div>".
    "<div class='text-center' style='padding-top: 25px'><input style='margin: auto' class='button-green' type='submit' value='PROCEED' /></div>",
    "./reader.php"
  );

  $adminCard = new MenuCard("For Admins",
    "<div style='padding-top: 5px'><label for='admin-id'>ID</label>".
    "<input type='text' pattern='[a-zA-Z0-9 ]+' id='admin-id' name='admin' placeholder='Admin ID...' required/></div>".
    "<div style='padding-top: 10px'><label for='admin-password'>Password</label>".
    "<input type='password' id='admin-password' name='password' placeholder='Password...' required/></div>".
    "<div style='padding-top: 15px;'><input style='margin: auto' class='button-green' type='submit' value='PROCEED' /></div>",
    "./admin.php"
  );

  # Main menu GUI
  $accessReader = new Component("<div class='col-12 col-md'>".$readerCard->getCode()."</div>");
  $accessAdmin = new Component("<div class='col-12 col-md'>".$adminCard->getCode()."</div>");
  $mainMenuComponent = new Component("<main id='home'>"."<div id='main-menu' class='container'><div class='row'>".$accessReader->getCode().$accessAdmin->getCode()."</div></div></main>");
  
?>