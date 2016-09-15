<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame 
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title>login</title>
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="stylesheet" href="css/default.css" type="text/css" />
</head>

<body>
  <div>
    <header>
      <h1>MCSO Case Login</h1>
    </header>
    <div>
        <form method="post" action="loginProcess.php">
            
            Username: (admin) <input type="text" name="username" /> <br />
            Password: (password) <input type="password" name="password" /> <br />
            <input type="submit" value="Login" name="loginForm" />
            
        </form>
      
    </div>

    <footer>
    </footer>
    
    
  </div>
</body>
</html>