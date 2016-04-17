<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="jquery-2.2.1.js" type="text/javascript"></script>
        <script src="aJax.js" type="text/javascript"></script>
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
        </div>
        
        <div id ="sqlQuery">
            <input type ="text" id="sqlBox" name ="sqlBox" value = "Type Here">
        </div>
        
        <select id ="databaseSel" name="databaseSel"> </select>
  
    </body>
</html>
