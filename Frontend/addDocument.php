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
                    $title = "Admin: $admin | Add Document Copy"; $body = new Body();
                    function getBranchOptions(){
                        global $sql;
                        $rows = $sql->execute("SELECT BId,Name From BRANCH");
                        $branches="";
                        $i=0;
                        foreach($rows as $key=>$value){
                            $branches.="<option value='".$value[0]."' ".((0==$i++)?"selected":" ").">".$value[1]."</option>";
                        }
                        return($branches);
                    }
                    $addReaderComponents = ("
                        <div class='container reader' style='min-height: 80vh;'>
                            <div class='row'>
                                <div class='col'>
                                    <h2>Add Document Copy</h2>
                                    <form class='form' method='post' action='./documentAdd.php'>
                                        <div>
                                            <label for='dname'>Document Title*</label><input id='dname' type='text' name='dname'  required/>
                                        </div>
                                        <div>
                                            <label for='pdate'> Published Date *</label><input id='pdate' type='date' name='pdate' required/>
                                        </div>
                                        <div>
                                            <label for='bid'>Type</label>
                                            <select id='bid' type='text' name='bid'>".getBranchOptions()."</select>
                                        </div>
                                        <div>
                                            <label for='position'>Position Shelf</label><br>
                                            <input id='position' type='text' name='position' required/>
                                        </div>
                                        <div>
                                            <label for='pubname'>Publisher Name</label><br>
                                            <input id='pubname' type='text' name='pubname' required/>
                                        </div>
                                        <div>
                                            <label for='pubaddress'>Publisher Address</label><br>
                                            <textarea name='pubaddress' id='pubaddress' required></textarea>
                                        </div>
                                        <div><button type='submit' class='button-green'>Add Document</button></div>
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