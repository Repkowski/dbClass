<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="jquery-2.2.1.js" type="text/javascript"></script>
        <script src="aJax.js" type="text/javascript"></script>
        <link href="wildStyle.css" rel="stylesheet" type="text/css"/>
        <title></title>
    </head>
    <body>
        <div id="LoginDiv">
          Server Address:<br>
          <input type="text" id="serverBox" name="serverBox" value = "23.253.61.96"> <br>
          Username: <br>
          <input type="text" id="userBox" name="userBox"> <br>
          Password: <br>
          <input type="password" id="passBox" name="passBox"> <br>
          <input type="button" value ="Sign In" name="submitBtn" onclick="ajaxAuthenticate()">
          <select id ="databaseSel" name="databaseSel" onchange="ajaxGetTables()" onblur="ajaxGetTables()"> </select>
          <select id="tableSel" name ="tableSel" onchange="getTableSchema()" onblur="getTableSchema()"> </select>
          <input type="button" id="displayTable" name ="displayTable" onclick="getAllTuples()" value="Get Tuples"> </button>
        </div>    
        

          
        <div id ="sqlQuery">
            <textarea id="sqlBox" name="sqlBox" rows ="10" cols="70"></textarea>
        </div>
        
        <div id="sqlReturn">
        
        </div>
        
        <div id="tableDiv">
            <table id="tableInfo" name ="tableInfo"> </table>
            <table id="currentTable" name="currentTable"> </table>
        </div>
        
    </body>
</html>
