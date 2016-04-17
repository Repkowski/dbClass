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

function getTables(){
    $dbConn = connectDb();
    
    if($dbConn->connect_error) {
        $val = $dbConn->connect_error;
    }
    else {
        $val = 0;
    }
    
    $query = "SHOW TABLES IN " . $_POST['db'];
    $sqlResult = $dbConn->query($query);
    $dbConn->close();
    
    $result = array();
    $result['error'] = $val;
    $result['tables'] = array();
    $j = 0;
    while( $row = $sqlResult->fetch_array()){
        $result['tables'][$j] = $row[0];
        $j++;
    }
    return json_encode($result);
}

function sqlQueryExec(){
    $dbConn = connectUser();
    
    if($dbConn->connect_errno){
        $val = $dbConn->connect_error;
    }
    else{
        $val = 0;
    }
    
    /*
     * TO-DO
     * Acquire the text from the SQL query box and execute that query
     */
}

function connectUser() {
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

function getUserCreds(){
    if(isset($_POST['server'])) {
        $server = sanitize($_POST['server']);
    }
    if(isset($_POST['username'])) {
        $username = sanitize($_POST['username']);
    }
    if(isset($_POST['password'])) {
        $password = sanitize($_POST['password']);
    }
    $credArray = array();
    $credArray[0]= $server;
    $credArray[1]= $username;
    $credArray[2]= $password;
    
    return $credArray;
    
}

function connectDb(){
   if(isset($_POST['db'])){
       $database = sanitize($_POST['db']);
   }
   
   $myArray = getUserCreds();
   reset($myArray); //resets internal pointer, makes sure we have base of array
   $server = current($myArray); //gets what is at current index of array
   next($myArray); //increments pointer to next index of array
   $username = current($myArray);
   next($myArray);
   $password = current($myArray);
   
   $dbConn = new mysqli($server, $username, $password, $database);
   
   return $dbConn;
}
?>