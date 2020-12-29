<?php 
    require_once('util/htmlUtil.php');
    require_once('util/sqlUtil.php');
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];
            $sql = new SQL();
            if(gettype($result = $sql->execute("SELECT * FROM ADMIN WHERE Id='$admin' AND Password='$password'"))=="array"){
                if(sizeof($result)>0){
                    $title = "Admin: $admin | Add Reader"; $body = new Body();
                    $addReaderComponents = ("
                        <div class='container reader' style='min-height: 80vh;'>
                            <div class='row'>
                                <div class='col'>
                                    <h2>Add Reader</h2>
                                    <form class='form' method='post' action='./readerAdd.php'>
                                        <div>
                                            <label for='rname'>Name*</label><input id='rname' type='text' name='rname'  required/>
                                        </div>
                                        <div>
                                            <label for='rphone'>Phone No*</label><input id='rphone' type='text' name='rphone' required/>
                                        </div>
                                        <div>
                                            <label for='raddress'>Address</label><br>
                                            <textarea id='raddress' type='text' name='raddress'></textarea>
                                        </div>
                                        <div>
                                            <label for='rtype'>Type</label>
                                            <select id='rtype' type='text' name='rtype'>
                                            <option value='student'>STUDENT</option>
                                            <option value='reader' selected>Normal Reader</option>
                                            <option value='senior'>SENIOR CITZEN</option>
                                            <option value='staff'>STAFF</option>
                                            </select>
                                        </div>
                                        <div>
                                            <button type='submit' class='button-green'>Add Reader</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <style>
                          .reader input{
                              border: 1px solid black;
                              margin-bottom: 20px;
                              margin-left: 20px;
                          }
                          .button-green{
                              margin: 30px;
                              padding: 10px 20px;
                          }
                        </style>
                    ");
                    $html = new HtmlDocument("City Library | $title", $body->getBody($addReaderComponents));
                    $html->setStyle($styleComponent->getCode()); $html->setScript($scriptComponent->getCode());
                    $html->printHTML();
                }
            }else{echo "<html><head><title>City Library | Access Denied</title></head><body>Access Denied</body><html>";}
        }
    }else{echo "<html><head><title>City Library | Access Denied</title></head><body>Access Denied</body><html>";}
?>