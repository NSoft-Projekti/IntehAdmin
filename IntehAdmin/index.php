<?php

require 'core.php';
require 'connect.php';


//if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])){
if(loggedin()){
    echo'you are logged in. <a href="logout.php">Log out</a>';
}else{
    include 'loginform.php';
}

?>