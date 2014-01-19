<?php
$conn_error = 'Could not connect';

$mysql_host = 'localhost';
$mysql_user = 'gogo';
$mysql_pass = 'gogo';

$mysql_db = 'mydb';

$con = mysql_connect($mysql_host, $mysql_user, $mysql_pass) or die ("Can't connect");

mysql_select_db($mysql_db) or die($conn_error);

echo'connecteddddd';

?>