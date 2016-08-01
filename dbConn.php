<?php
function dbConn(){
    $servername = getenv('IP');
    $dbPort = 3306;
    // Which database (the name of the database in phpMyAdmin)?
    $database = "caseDB";
    
    // My user information...I could have prompted for password, as well, or stored in the
    // environment, or, or, or (all in the name of better security)
    $username = getenv('C9_USER');
    $password = "";
    
    // Create connection
    $conn = new PDO("mysql:host=$servername;port=$dbPort;dbname=$database", $username, $password);
    // Check connection
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    return $conn;
}

function getDataBySQL($sql) {
    global $connection;
    $statment = $connection -> prepare($sql);
    $statment -> execute();
    $records = $statment -> fetchALL (PDO::FETCH_ASSOC);
    return $records;
}

?>