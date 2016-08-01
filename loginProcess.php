<?php 
session_start(); //start or resume an existing session 

include 'dbConn.php'; 

$connection = dbConn(); 

if (isset($_POST['loginForm'])) { //checks whether user submitted the form 
     
    $username = $_POST['username']; 
    $password = hash("sha1",$_POST['password']);  //hash("sha1", $_POST['password']) 
    
    
    $sql = "SELECT *  
            FROM users 
            WHERE username = :username 
            AND password = :password";  //Preventing SQL Injection 
             
    $namedParameters = array(); 
    $namedParameters[':username'] = $username;                 
    $namedParameters[':password'] = $password;             
     
    $statement = $connection->prepare($sql);  
    $statement->execute($namedParameters); 
    $record = $statement->fetch(PDO::FETCH_ASSOC); 
     
    if (empty($record)) { //wrong username or password 
         
        echo "Wrong username or password!"; 
         
    } else if ($record['active'] == 0){
        header("Location:index.php");
    } else { 
         
        $_SESSION['username'] = $record['username']; 
        $_SESSION['lastname'] = $record['lastname']; 
        $_SESSION['firstname'] = $record['firstname']; 
        $_SESSION['rank'] = $record['rank'];
        $_SESSION['userID'] = $record['userID'];
        header("Location: main.php");
    } 
     

     
} 

?>