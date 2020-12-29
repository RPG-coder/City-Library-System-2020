<?php
  // FIXME: Work with solving SQL Injection - Low Priority
  /*
      private function checkSQLInjectionsBasic($statement){
        if()
        return true;
        return false;
      }
      checkSQLInjectionsBasic($statement) &&
  */
  class SQL{
      private $sqlObject;
      function __construct(){
        $this->sqlObject = new mysqli("localhost","root","root123","CityLibrary");
      }
      
      function execute($statement){
        if(!($this->sqlObject)->connect_error){
            $result = ($this->sqlObject)->query($statement);
            if($result){
                if(gettype($result)=='object' && mysqli_num_rows($result)>0){
                    $array = $result->fetch_all();
                    return $array;
                }else{return $result;}
            }else{
                echo "<script>console.log('Error: SQL-Query did not execute!!')</script>";
                return null;
            }
        }else{
            echo "<script>console.log('Error: SQL-Connection error!!')</script>";
            return null;
        }
      }

      function prepare($statement){
        if(!($this->sqlObject)->connect_error){
          return ($this->sqlObject)->prepare($statement);
        }else return null;
      }
  }
?>