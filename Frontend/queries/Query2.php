<?php
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];

            $sql = new mysqli("localhost","root","root123","CityLibrary");
            if ($sql->connect_error) {die("Connection failed: " . $conn->connect_error);}
            if(isset($_GET['N']) && $_GET['N']!=null){
                echo "<br/><a href='../admin.php'>Home</a><br/>";
                
                $result = $sql->query(
                    "select count(*) As borrowed, document.DocId, document.title ".
                    "from borrows left join document on document.DocId = borrows.DocId ".
                    "group by DocId order by count(document.DocId) desc limit ".$_GET['N']
                );
                echo(
                    "<div style='margin-top:20px;'>
                        ".$_GET['N']." most borrowed books in the library
                    </div>"
                );
                if($result->num_rows > 0){
                    
                    echo "<table>";
                    echo "<tr><td>No of Borrowed</td><td>DocId</td><td>Title</td>"."</tr>";
                    while($row = $result->fetch_assoc()){
                        echo "<tr>"."<td>".$row['borrowed']."</td>"."<td>".$row['DocId']."</td>"."<td>".$row['title']."</td>"."</tr>";
                    }echo "</table>";
                }else{
                    echo "No Results";
                }
            }

            
            if(isset($_GET['year']) && $_GET['year']!=null){
                $result = $sql->query(
                    "select count(*) As borrowed, document.DocId, document.title ".
                    "from bor_transaction right join borrows on bor_transaction.BorNumber = borrows.BorNumber ".
                    "left join document on document.DocId = borrows.DocId ".
                    "inner join book on book.BookId = borrows.DocId where year(bor_transaction.BorDateTime) = '".$_GET['year']."' ".
                    "group by year(bor_transaction.BorDateTime), DocId".
                    " order by count(document.DocId) desc limit 10"
                );
                echo(
                    "<div style='margin-top:20px;'>
                        10 most popular books of year ".$_GET['year']." in the library
                    </div>"
                );
                if($result->num_rows > 0){
                    
                    echo "<table>";
                    echo "<tr><td>No Of Borrowed</td><td>DocId</td><td>Title</td></tr>";
                    while($row = $result->fetch_assoc()){
                        echo "<tr>"."<td>".$row['borrowed']."</td>"."<td>".$row['DocId']."</td>"."<td>".$row['title']."</td>"."</td>"."</tr>";
                    }echo "</table>";
                }else{
                    echo "No Results";
                }
            }

            if(isset($_GET['start_date']) && isset($_GET['end_date']) && $_GET['start_date']!=null && $_GET['end_date']!=null){
                $result = $sql->query(
                    "select fine_in_branch.Name, avg(fine_in_branch.BorrowedFine) * 0.2 as AvgFine from ( select branch.Name,".
                    " branch.BId, datediff(bor_transaction.RetDateTime, bor_transaction.BorDateTime) - 10 as BorrowedFine".
                    " from borrows left join bor_transaction on bor_transaction.BorNumber = borrows.BorNumber left join ".
                    "branch on branch.BId = borrows.BId inner join book on book.BookId = borrows.DocId where ".
                    "bor_transaction.BorDateTime >= '".$_GET['start_date']."' and bor_transaction.BorDateTime < '"
                    .$_GET['end_date']."' and datediff(bor_transaction.RetDateTime, bor_transaction.BorDateTime) - 20 > 0 ) ".
                    "fine_in_branch group by fine_in_branch.BId"
                );
                echo(
                    "<div style='margin-top:20px;'>".
                        "average fine paid by the borrowers for documents borrowed from a branch from ".$_GET['start_date']." till ".$_GET['end_date'].".".
                    "</div>"
                );
                if($result->num_rows > 0){
                    
                    echo "<table>";
                    echo "<tr><td>Name</td><td>AvgFine</td>"."</tr>";
                    while($row = $result->fetch_assoc()){
                        echo "<tr>"."<td>".$row['Name']."</td>"."<td>".$row['AvgFine']."</td>"."</tr>";
                    }echo "</table>";
                }else{
                    echo "No Results";
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