<?php
  class Component{
    private $code;    
    function __construct($aCode){
      $this->code = $aCode;
    }
    function getCode(){return $this->code;}
  }
?>

<?php
  class Body{
    private $header, $footer;
    
    function __construct(){
      global $isAdmin;
      $this->header = (
        new Component(
          "<header><nav><div class='container-fluid'><div class='row'><div class='col-12 col-md-4'><a><div id='logo-container'><picture><img src='./images/library-logo.svg' alt='City Library Logo'/></picture><h1>CITY LIBRARY</h1></div></a></div><div class='col-12 col-md-8'>".
          (
            ( (isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"]) || (isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]) )?
            "<div class='link-set'><ul><li><a href=".((!(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]))?'./reader.php':'./admin.php').">Home</a></li>".
            ((isset($isAdmin)&&$isAdmin)?"":"<li><a href='./profile.php'>Profile</a></li>").
            "<li><a href='./about.php'>About</a></li>".
            ((isset($isAdmin)&&$isAdmin)?"":"<li><a style='font-size: 1.2rem' href='./cart.php'>&#128722;</a></li>").
            "<li id='user-greeting'><a href='./logout.php'>Log Out</a></li></ul></div>":""
          ).
          "</div></div></div></nav></header>"
        )
      )->getCode();


      $this->footer = (
        new Component(
          "<footer><div class='container'><div class='row'><div class='col'>".
          "<div class='hr-white'></div>".
          "<div>&copy; Copyright Privacy Policy</div></div></div></div>".
          "</footer>"
        )
      )->getCode();
    }
    function getBody($body){
      return $this->header.$body.$this->footer;
    }
  }
  $styleComponent = new Component(
      "<link rel='preconnect' href='https://fonts.gstatic.com'>".
      "<link href='https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&display=swap' rel='stylesheet'>".
      "<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' integrity='sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2' crossorigin='anonymous'>".
      "<link rel='stylesheet' type='text/css' href='./css/style.css' >"
  );
  $scriptComponent = new Component(
      "<script src='https://code.jquery.com/jquery-3.5.1.min.js' integrity='sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=' crossorigin='anonymous'></script>".
      "<script src='https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js' integrity='sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN' crossorigin='anonymous'></script>".
      "<script src='https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js' integrity='sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s' crossorigin='anonymous'></script>"
  );
?>

<?php
  class HtmlDocument{
    private $title, $body, $style, $script;

    function __construct($htmlTitle, $htmlBody){
      $this->title = $htmlTitle;
      $this->body  = $htmlBody;
    }

    function setScript($script){ $this->script = $script; }
    function setStyle($style){ $this->style = $style; }

    function printHTML(){
      echo (
        "<!DOCTYPE html><html lang='en'>".
        "<head><meta charset='UTF-8'><meta name='viewport' content='width=device-width, initial-scale=1.0'><title>$this->title</title>".
        (($this->style)?$this->style:"")."</head>"."<body>".$this->body.(($this->script)?$this->script:"")."</body></html>"
      );
    }
  }
?>