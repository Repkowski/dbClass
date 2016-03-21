<?php 

echo $_POST['method']();

function sanitize($str, $quotes = ENT_NOQUOTES){
    $str = htmlspecialchars($str, $quotes);
    return $str;
}

function authUser(){
    if(isset($_POST['server'])){
        $server = sanitize($_POST['server']);
    }
    if(isset($_POST['username'])){
        $username = sanitize($_POST['username']);
    }
    if(isset($_POST['username'])){
        $password = sanitize($_POST['password']);
    }
    
    $dbConn = mysqli_connect($server, $username, $password);
    
    if($dbConn->connect_error) {
            $val = $dbConn->connect_error;
    }
    else {
            $val = 0;
            //echo "Success, thanks ". $username;
    }
  $dbConn->close();
   //Put the result into an array and return as JSON
  $result = array();
  $result['error'] = $val;
    
  return json_encode($result);
}

function getDatabases() {
    if (isset($_POST['server']))
    {
        $server = sanitize($_POST['server']);
    }
    
    if (isset($_POST['username']))
    {
        $username = sanitize($_POST['username']);
    }
    
    if (isset($_POST['password']))
    {
        $password = sanitize($_POST['password']);
    }
    
    $databaseNames = array();
    
    $dbConn = new mysqli($server, $username, $password);
   // $dbConn = mysqli_connect('23.253.61.96', 'admin_dbMatt', '');
    $query = "SHOW DATABASES";
    $sqlResult = $dbConn->query($query);
    $dbConn-> close();
    
    if($result){
        while ($row = $result->fetch_array()){
            array_push($databaseNames, $row[0]);
        }
    }
    
//    $return = new stdClass;
//    $return->success = true;
//    $return->errprMessage = "";
//    $return->data['database_names'] = $databaseNames;
//    $json = json_encode($return);
//    echo $json;
    $result = array();
    $result['error'] = $val;
    $result['databases'] = array();
    
    $i = 0;
    while($row = $sqlResult->fetch_array()){
       $result['databases'][$i] = $row[0];
       $i++;
    }
    
    return json_encode($result);   
}
?>