<?php

if(isset($_POST['username']) && isset($_POST['password'])){

    $username=$_POST['username'];
    $password=$_POST['password'];

    if(!empty($username) && !empty($password)){

        $query="SELECT `idkorisnici` FROM `korisnici` WHERE `username`='$username' AND `password`='$password'";

        if($query_run=mysql_query($query))
        {
            $query_num_rows=mysql_num_rows($query_run);
            if($query_num_rows==0){
                echo'invalid username/password combination';
            }else if ($query_num_rows==1){
                $user_id=mysql_result($query_run, 0, 'idkorisnici');
                $_SESSION['user_id']=$user_id;
                header('Location: index.php');
            }
        }
    }else{
        echo'you must enter username and password';
    }

}

?>

<form action="<?php echo $current_file; ?>" method="POST">
    Username: <input type="text" name="username"></br>
    Password: <input type="password" name="password">
    <input type="submit" value="Submit">
</form>