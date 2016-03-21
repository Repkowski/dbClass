<?php
function dbConnect($serverIP, $username, $password){
$mysqli = mysqli_connect($serverIP, $username, $password);
if(mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
return $mysqli;
}
?>


