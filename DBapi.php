<?php 

echo $_POST['method']();

function sanitize($str, $quotes = ENT_NOQUOTES){
    $str = htmlspecialchars($str, $quotes);
    return $str;
}

function authUser(){
    //Create a new connection to the server
    $dbConn = connectUser();
    
    //Check for errors, if 0 then successfully connected
    if($dbConn->connect_error) {
            $val = $dbConn->connect_error;
    }
    else {
            $val = 0;
    }
    $dbConn->close();
    //Put the result in to an array and return as JSON
    $result = array();
    $result['error'] = $val;
    
    return json_encode($result);

}

function getDatabases() {
  $dbConn = connectUser();
   // $dbConn = mysqli_connect('23.253.61.96', 'admin_dbMatt', '');
    
    if($dbConn->connect_error) {
            $val = $dbConn->connect_error;
    }
    else {
            $val = 0;
    }
    
    $query = "SHOW DATABASES";
    $sqlResult = $dbConn->query($query);
    $dbConn-> close();
    
    $result = array();
    $result['error'] = $val;
    $result['databases'] = array();
    $i = 0;
    while( $row = $sqlResult->fetch_array()) {
        $result['databases'][$i] = $row[0];
        $i++;
    }
    return json_encode($result);
}
function connectUser() {
            //Check to see if the proper variables were POSTed
    if(isset($_POST['server'])) {
        $server = sanitize($_POST['server']);
    }
    if(isset($_POST['username'])) {
        $username = sanitize($_POST['username']);
    }
    if(isset($_POST['password'])) {
        $password = sanitize($_POST['password']);
    }
    $dbConn = new mysqli($server, $username, $password);
    
    return $dbConn;
}
?>