<?php
    session_start();
    if(isset($_SESSION["admin_logged"])&&$_SESSION["admin_logged"]){
        if(isset($_SESSION["admin"]) && isset($_SESSION["password"])){
            $admin = $_SESSION["admin"];
            $password = $_SESSION["password"];

?>
    <form method='get' action='queries/Query1.php'>
        <h1> GET Query Set 1-3</h1>
        <div>
            <label for='a1'>N : </label><input id='a1' type='number' name='N' pattern='[0-9]'  required/>
        </div>
        <div>
            <label for='a2'>I : </label><input id='a2' type='number' name='I' pattern='[0-9]'/>
        </div>
        <div>
            <button style='margin-left:50px;' type='submit'>Submit</button>
        </div>
    </form>

    
    <form method='get' action='queries/Query2.php'>
    <h1>GET Query Set 4-6</h1>    
        <div>
            <label for='a3'>N : </label><input id='a3' type='number' name='N' pattern='[0-9]'  required/>
            <button style='margin-left:50px;' type='submit'>Submit</button>
        </div>
    </form>
    <form method='get' action='queries/Query2.php'>
        <div>
            <label for='a4'>Year : </label><input id='a4' type='number' name='year'max=2020 pattern='[0-9]' required/>
            <button style='margin-left:50px;' type='submit'>Submit</button>
        </div>
    </form>
    <form method='get' action='queries/Query2.php'>
        <div>
            <label for='a5'>START DATE : </label><input id='a5' type='date' name='start_date'  required/>
        </div>
        <div>
            <label for='a6'>END DATE : </label><input id='a6' type='date' name='end_date'  required/>
        </div>
        <div >
            <button style='margin-left:50px;' type='submit'>Submit</button>
        </div>
    </form>
    <style>
        input{
            padding: 10px;
            margin: 5px;
            width: 200px;
        }
        form{
            margin: 5%;
        }
    </style>
<?php
            
        }
    }else{
        echo 'Access Denied';
    }
?>