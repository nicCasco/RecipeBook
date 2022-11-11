<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'mysql01.cs.virginia.edu');
define('DB_USERNAME', 'nic4ud');
define('DB_PASSWORD', 'Mickeymouse01!');
define('DB_NAME', 'nic4ud_c');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>