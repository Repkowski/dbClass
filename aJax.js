function loadPhpInfo(){
    var xhttp;
    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function(){
        if (xhttp.readState === 4 && xhttp.status === 200){
            document.getElementById("ajaxSample.innerHTML = xhttp.responseText;")
            //Changing the element above changes where you post your results
        }
    };
    xhttp.open("GET", "AjaxSameple1.php", true); //change this to pick what php
                                                //command I want to pass in
    xhttp.send();
}

function ajaxAuthenticate(){
    var server = $("#serverAddressBox").val();
    var username = $("#usernameBox").val();
    var password = $("#passwordBox").val();
    data = {method: 'authUser', server: server, username: username, pass: password}; 
    
    ajaxCall(data, auth);
}

function auth(data){
    var val = JSON.parse(data);
    if(val['error'] != null){
        if(val['error'] == 0)
            //user succesfully authenticated, gets his databases
            ajaxGetDB($("#serverAddressBox").val(), $("#usernameBox").val(), 
                        $("#passwordBox").val()); 
    }
}


function ajaxGetDB(server, username, password){
       data = {method: 'getDatabases', server: server, username: username, 
                      password: password};
       ajaxCall(data, getDB);      
}

function getDB(data){
    var val = JSON.parse(data);
    var dbSelect = $("#databaseSel");
    dbSelect.empty();
    if (val['error'] === 0){
        $.each(val['databases'], function(index, value){
            dbSelect.append($("<option>",{
                value: value,
                text: value
            }));
        });
    }
}


function ajaxCall(data, method){
    $.ajax({
        url: 'DBapi.php',
        data: data,
        type: 'post',
        datatype: 'json',
        success: function(return_value){
            method(return_value);
        },
        error: function(xhr, message){
            alert("I am Error");
        }
    });
}


