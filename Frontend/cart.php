<?php
    require_once("util/sqlUtil.php");
    require("readerMenuComponents.php");
    session_start();
    if(isset($_SESSION["reader_logged"])&&$_SESSION["reader_logged"]){
        if(isset($_SESSION["lastCardNumber"])){
            $cardNumber = $_SESSION["lastCardNumber"];
            $title = "Cart | Reader: $cardNumber";
            
            class Cart{
                function createCartInstance($cartId,$DocId,$DocName,$PublisherName,$NumberOfCopies){
                    return (
                    "<div cartId='$cartId' class='row  text-center m-1 p-4 search-instance' style='text-transform:uppercase;background-color:#e4e4e4'>
                        <div style='font-size:1.25rem' class='col-12 col-md-1'>$DocId</div>
                        <div class='col-12 col-md-4'>
                            <p style='font-size:1.25rem'>$DocName &nbsp;<small>$PublisherName</small></p>
                        </div>
                        <div class='col-12 col-md-2'>
                            <p style='font-size:1rem'>$NumberOfCopies</p>
                        </div>
                        <div class='col-12 col-md-2 p-1'>
                            <a href='./cart/borrowFromCart.php?cartId=$cartId'>
                                <button style='margin-right:20px;padding:10px 20px;border-radius:10px' class='button-green'>Borrow</button>
                            </a>
                        </div>
                        <div class='col-12 col-md-2 p-1'>
                            <a href='./cart/reserveFromCart.php?cartId=$cartId'>
                                <button style='margin-right:20px;padding:10px 20px;border-radius:10px' class='bg-danger text-white'>Reserve</button>
                            </a>
                        </div>
                        <div class='col-12 col-md-1 p-1'>
                            <a href='./cart/removeFromCart.php?cartId=$cartId'>
                                <button style='margin-right:20px;padding:10px 20px;border-radius:10px'>&#x26D4</button>
                            </a>
                        </div>    
                    </div>");
                }
                function getCode(){
                    $cartCode="";
                    if(isset($_SESSION["cart"])&&gettype($_SESSION["cart"])=="array" && sizeof($_SESSION["cart"])>0){
                        foreach($_SESSION["cart"] as $key=>$value){
                            $cartCode .= $this->createCartInstance($key,$value["DocId"],$value["DocName"],$value["PublisherName"],$value["NumberOfCopies"]);
                        }
                        return (
                            $cartCode.
                            "<div class='mt-4 col-12 my-2'><div><a href='./cart/borrowAllFromCart.php' style='text-decoration:none;margin-right:20px;padding:10px 20px;border-radius:10px' class='button-green'>Borrow All</a>:(with one BorrowId)</div></div>".
                            "<div class='col-12 my-5'><div><a href='./cart/reserveAllFromCart.php' style='text-decoration:none;margin-right:20px;padding:10px 20px;border-radius:10px' class='bg-danger text-white'>Reserve All</a>:(with one ReserveId)</div></div>"
                        );
                    }else{
                        return("<div class='text-center m-5'>This Cart Is Empty</div>");
                    }
                }
            };
            $cartCodeComponent = (new Cart())->getCode();
            $cartPageCode = (
                "<main id='cart-page'>".$searchBoxComponentLight->getCode().
                "<div class='hr-grey' style='width:75%'></div>".
                "<div class='container'>".
                "<h2 class='mb-5'><strong>Reader's Cart</strong></h2>".
                $cartCodeComponent.
                "</div>".
                "<div class='hr-grey' style='width: 75%'></div>".
                $commonSubsetMenu."</main>"
            );

            $body = new Body();
            $html = new HtmlDocument("City Library | $title", $body->getBody($cartPageCode));
            $html->setStyle($styleComponent->getCode());
            $html->setScript($scriptComponent->getCode());
            $html->printHTML();
        }
    }else{
        $html = new HtmlDocument("City Library | SEARCH", "Access Denied");
        $html->printHTML();
    }

?>