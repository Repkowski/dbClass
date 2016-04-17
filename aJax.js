function ajaxAuthenticate(){
    var serverIP = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    data = {method: 'authUser', server: serverIP, username: username, password: password};
    
    ajaxCall(data, auth);
}

function auth(data){
var val = JSON.parse(data);
    if(val['error'] !== null){
        if(val['error'] === 0)
            //user succesfully authenticated, gets databases
            ajaxGetDB($("#serverBox").val(), $("#userBox").val(), 
                        $("#passBox").val()); 
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


