<?php
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];

            if(isset($_GET['N'])){
                $sql = new mysqli("localhost","root","root123","CityLibrary");
                if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
                echo "<br/><a href='../admin.php'>Home</a><br/>";


                $result = $sql->query(
                    "SELECT B.READERID,R.ReaderName,B.BId,COUNT(*) as 'borrowed' FROM reader R, borrows B".
                    " where B.ReaderId=R.ReaderId AND B.ReaderId in (SELECT ReaderId FROM borrows B1, authors A WHERE B1.DocId=A.BookId)".
                    " GROUP BY B.ReaderId,B.BId ORDER BY COUNT(*) DESC LIMIT ".$_GET['N']
                );
                if($result->num_rows > 0){
                    echo(
                        "<div style='margin-top:20px;'>
                          The Top N most frequent borrowers (Rid and name) in the library and".
                          " the number of books each has borrowed.<br>
                        </div>"
                    );
                    echo "<table>";
                    echo "<tr><td>READERID</td><td>ReaderName</td><td>Branch</td><td>borrowed</td></tr>";
                    while($row = $result->fetch_assoc()){
                        echo "<tr>"."<td>".$row['READERID']."</td>"."<td>".$row['ReaderName']."</td>"."<td>".$row['BId']."</td>"."<td>".$row['borrowed']."</td>"."</tr>";
                    }echo "</table>";
                }

                if(isset($_GET['I'])){
                    $result = $sql->query(
                        "SELECT TITLE,COUNT(*) AS 'BORROWED' FROM borrows B, document D ".
                        "WHERE B.DOCID=D.DOCID AND B.DOCID IN (SELECT DOCID FROM BORROWS B1,book B2 WHERE B1.BID=".$_GET['I']." AND B1.DOCID=B2.BOOKID)".
                        " GROUP BY TITLE ORDER BY COUNT(*) DESC LIMIT ".$_GET['N']
                    );
                    if($result->num_rows > 0){
                        echo(
                            "<div style='margin-top:20px;'>N most borrowed books in branch I</div>"
                        );
                        echo "<table>";
                        echo "<tr><td>READERID</td><td>ReaderName</td>"."</tr>";
                        while($row = $result->fetch_assoc()){
                            echo "<tr>"."<td>".$row['TITLE']."</td>"."<td>".$row['BORROWED']."</td>"."</tr>";
                        }echo "</table>";
                    }
                }

                if(isset($_GET['I'])){
                    $result = $sql->query(
                        "select R.READERID,R.ReaderName,COUNT(*) as 'borrowed' FROM reader R, borrows B ".
                        "where B.ReaderId=R.ReaderId AND B.ReaderId in (".
                            "SELECT ReaderId FROM borrows B1, authors A WHERE B1.BID=".$_GET['I']." AND B1.DocId=A.BookId".
                        ") GROUP BY ReaderId ORDER BY COUNT(*) DESC LIMIT ".$_GET['N']
                    );
                    if($result->num_rows > 0){
                        echo(
                            "<div style='margin-top:20px;'>
                              Top N most frequent borrowers (Rid and name) in Branch ID".$_GET['I']." and the number of books each has Reader borrowed.<br>
                            </div>"
                        );
                        echo "<table>";
                        echo "<tr><td>READERID</td><td>ReaderName</td><td>borrowed</td>"."</tr>";
                        while($row = $result->fetch_assoc()){
                            echo "<tr>"."<td>".$row['READERID']."</td>"."<td>".$row['ReaderName']."</td>"."<td>".$row['borrowed']."</td>"."</tr>";
                        }echo "</table>";
                    }
                }
            }
            echo "<br/><a href='../admin.php'>Home</a><br/>";
        }
        echo ("
            <style>
                table{
                    padding: 1%;
                    margin: 1%;
                }
                td{
                    width: 200px;
                    height: 20px;
                }
                *{
                    font-size: 1.2rem;
                }
            </style>");
    }else{
        echo 'Access Denied';
    }
?>