<?php

require 'core.php';
require 'connect.php';

echo 'prva stranica';
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style_login.css">
</head>
<body>
<?php
if (!loggedin()){


?>
<div id="page">
    <div id="logo_login"> <img src="intech_logo.png" />
    </div>
    <div id="login_form">
        <form action="<?php echo $current_file; ?>" id="form1" method="POST">

            <div id="username1">
                Username:<br><br><input type="text" id="input_username" name="username">
            </div>
            <div id="password1">
                Password:<br><br><input type="password" id="input_password" name="password">
            </div>
            <div>
                <input type="submit" name="login_submit" id="login_submit" value="Log in">
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
if(isset($_POST['username']) && isset($_POST['password'])){

    $username=mysql_real_escape_string($_POST['username']);
    $password=mysql_real_escape_string($_POST['password']);

    if(!empty($username) && !empty($password)){

        $query1=mysql_query("SELECT id_korisnici, zanimanje FROM korisnici WHERE username='$username' AND password='$password'");

        if($query1)
        {
            $query_num_rows1=mysql_num_rows($query1);
            if($query_num_rows1==0){
                echo'invalid username/password combination';
                session_destroy();

            }else if ($query_num_rows1==1){

                $user_id=mysql_result($query1, 0, 'id_korisnici');
                $zanimanje=mysql_result($query1, 0, 'zanimanje');

                $_SESSION['user_id'] = $user_id;
                $_SESSION['zanimanje'] = $zanimanje;

                $stranica=$zanimanje;
            }
        }
    }else{
        echo'you must enter username and password';
    }
}
?>
</div>
<?php if (loggedin()){?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div id="page">
    <div id="header">
        <img src="intech_logo.png" id="intech_logo" />
    </div>
    <div id="left">
        <p>Ime Korisnika</p>
        <p>
        <ul>
            <li><a href="index.php?stranica=primka_nova">Primka</a></li>
            <li><a href="index.php?stranica=otpremnica_nova">Otpremnica</a></li>
            <li><a href="index.php?stranica=pregled_stanje">Pregled</a></li>
        </ul>
        </p>
    </div>
    <div id="right">
        <?php
        if(isset($_REQUEST['akcija'])){
            $akcija=$_REQUEST['akcija'];
        }else{
            $akcija='';
        }
        if(isset($_REQUEST['stranica'])){
            $stranica=$_REQUEST['stranica'];
        }
        include $stranica . ".php";
        }
        ?>
    </div>
</div>
</body>
</html>


