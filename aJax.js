var CurtableData = {}; 

function ajaxAuthenticate(){
    var server = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    data = {method: 'authUser', server: server, username: username, password: password};
    
    ajaxCall(data, authSuccess);
}

function authSuccess(data){
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
       ajaxCall(data, getDBSuccess);      
}

function getDBSuccess(data){
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
    ajaxCall(data, getTableSuccess);
}

function getTableSuccess(data){
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

function getTableSchema(){
    var server = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    var db = $("#databaseSel").val();
    var table = $("#tableSel").val();
    
    data ={method: 'getSchema', server: server, username: username, password: password,
            db: db, table: table};
        
    ajaxCall(data, getTableSchemaSuccess);
}

function getTableSchemaSuccess(data){
    var val = JSON.parse(data);
    var table = $("#tableInfo");
    
    if(val['error'] === 0){
        table.empty();
    table.append("<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>");
    $.each(val['field'], function(index, val){
        table.append("<tr><td>" + val['field'][index] + "</td><td>" + val['type'][index] + "</td><td>" + val['null'][index] + "</td><td>");
        table.append(val['key'][index] + "</td><td>" + val['default'][index] + "</td><td>" + val['extra'][index] + "</td></tr>");
    });
 
    $("#currentTable").html("");
    
    
    CurtableData['primary'] = val['primary'];
    CurtableData['keyColumn'] = val['keyColumn'];
    CurtableData['referencedTable'] = val['referencedtable'];
    CurtableData['referencedColumn'] = val['referencedColumn'];
    }
}

function getAllTuples(){
    var server = $("#serverBox").val();
    var username = $("#userBox").val();
    var password = $("#passBox").val();
    var db = $("#databaseSel").val();
    var table =$("#tableSel").val();
    
    data ={method: 'getTuples', server: server, username: username, password: password,
                db: db, table: table};
            
    ajaxCall(data, getTuplesSuccess);
}

function getTuplesSuccess (data){
    var val = JSON.parse(data);
    var table = $("#tableDiv");
    table.html("");
    if (val['error'] === 0){
        // FILL
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


