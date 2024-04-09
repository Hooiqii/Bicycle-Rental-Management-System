<?php

// if(!isset($_SERVER['HTTP_REFERER'])){
//     header('location: ./adminHomepage.php');
//     exit;
// }

define("SERVERNAME", "localhost");
define("DBNAME", "bicycle_rental"); // only change this if ur database name is different
define("USERNAME", "root");
define("PASSWORD", "");

$conn = new PDO("mysql:host=".SERVERNAME.";dbname=".DBNAME.";",USERNAME, PASSWORD);

// if($conn == true) {
//     echo "connected successfully";
// } else {
//     echo "connection failed";
// }

?>