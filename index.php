<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <script src="jquery-2.2.1.js" type="text/javascript"></script>
        <script src="aJax.js" type="text/javascript"></script>
        <title></title>
    </head>
    <body>
         
          Server Address:<br>
          <input type="text" name="serverAddressBox" value = "23.253.61.96"> <br>
          Username: <br>
          <input type="text" name="usernameBox"> <br>
          Password: <br>
          <input type="password" name="passwordBox"> <br>
          <input type="button" value ="Sign In" name="submitBtn" onclick="ajaxAuthenticate()">
          
        <input type="button" value="Get Databases" onclick="ajaxGetDB()"> 
        
        <select id ="databaseSel" name="databaseSel">
            
        </select>
         
    </body>
</html>
