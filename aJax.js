function ajaxAuthenticate(){
    var server = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    data = {method: 'authUser', server: server, username: username, password: password};
    
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

function ajaxGetTables(){
    var server = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    var db = $("#databaseSel").val();
    
    data ={method: 'getTables', server: server, username: username, password: password,
            db: db};
    ajaxCall(data, getTableJS);
}

function getTableJS(data){
    var val = JSON.parse(data);
    var tableSelect = $("#tableSel");
    tableSelect.empty();
    if (val['error'] === 0){
        $.each(val['tables'], function(index, value){
            tableSelect.append($("<option>",{
                value: value,
                text: value
            }));
        });
    }
}

function ajaxQuery(server, username, password){
    var query = $("#sqlBox").val();
    data ={method: 'sqlQueryExec', server: server, username: username, 
        password: password, query: query};
    ajaxCall(data, execQuery);
}

function execQuery(data){
    var val = JSON.parse(data);
    
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


