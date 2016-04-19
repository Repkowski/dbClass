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
/*
 * Thank you Jason!
 */
function getSchema() {
//getSchema - get the schema of the specified table in a DB
//                   needs a 'server', 'user', 'pass', 'db' , 'table' to be posted to the page
//                   these correspond to the server to connect to and the 
//                   username and password to authenticate as well as the DB and
//                   table to get the schema of    
    
    //Check to see if the proper variables were POSTed
    if(isset($_POST['table'])) {
        $table = sanitize($_POST['table']);
    }
    
    
    //Create a new connection to the server
    $dbConn = connectDB();
    
    if($dbConn->connect_error) {
            $val = $dbConn->connect_error;
    }
    else {
            $val = 0;
    }
    
    //Execute the query to get the schema
    $query = "DESCRIBE " . $table;  
    $sqlResult = $dbConn->query($query);
    
    //Get the primary key columns
    $sql = "SHOW INDEX FROM ". $table . " WHERE key_name = 'PRIMARY';";
    $indexResult = $dbConn->query($sql);
    
    //Get the foreign keys for the table
    $foreignSQL = "SELECT column_name, referenced_table_name, referenced_column_name FROM information_schema.KEY_COLUMN_USAGE WHERE CONSTRAINT_SCHEMA = '" . $_POST['db'] . "' and REFERENCED_TABLE_SCHEMA IS NOT NULL and table_name = '" . $table . "'";
    $foreignResult = $dbConn->query($foreignSQL);
    $dbConn->close();
    
    //Put the results into an array and return as JSON
    $result = array();
    $result['error'] = $val;
    $i = 0;
    while( $row = $sqlResult->fetch_array()) {      
        $result['field'][$i] = $row[0];    //0 corresponds to the field name
        $result['type'][$i] = $row[1];     //1 corresponds to the data type
        $result['null'][$i] = $row[2];     //2 corresponds to if null is allowed
        $result['key'][$i] = $row[3];      //3 corresponds to if it is part of a key
        $result['default'][$i] = $row[4];  //4 corresponds to the default value if there is one
        $result['extra'][$i] = $row[5];    //5 corresponds to any extra information if there is any
        $i++;
    }
    
    //Parse the primary key into the result
    $i = 0;
    while($row = $indexResult->fetch_array()) {
        $result['primary'][$i] = $row[4];
        $i++;
    }
    
    //Parse the foreign keys into the result
    $j = 0;
    while($row = $foreignResult->fetch_array()) {
        $result['keyColumn'][$j] = $row[0]; //0 corresponds to the column_name
        $result['referencedtable'][$j] = $row[1]; //1 corresponds to the referenced_table_name
        $result['referencedColumn'][$j] = $row[2]; //2 corresponds to the referenced_column_name
        $j++;
    }
    
    return json_encode($result);
}



function getTuples(){
 /*  $dbConn = connectDb();
   
   if($dbConn->connect_error) {
        $val = $dbConn->connect_error;
    }
    else {
        $val = 0;
    }
    
    $query = "SELECT * FROM " . $_POST['table'];
    $sqlResult = $dbConn->query($query);
    $dbConn->close();
    
    echo "<table>"; // Start table tag in HTML
    
  while($row = mysqli_fetch_array($sqlResult)){
       echo "<tr><td>" . $row['name'];
   }
    
    
 */   
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