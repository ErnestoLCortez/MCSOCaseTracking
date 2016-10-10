<!DOCTYPE html>
<?php
//Check the session and connect to the database
session_start();
if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    header("Location: index.php");
}

include 'dbConn.php';
$connection = dbConn();

<<<<<<< HEAD
include 'navbarFuncs.php';

// echo "<a href='main.php'>Home</a><br>";

=======
>>>>>>> 077b017984179141a0e35572e723283ed62f701b
if (isset($_GET['commentCase'])) {  //admin submitted form to add product
    
  
  
  $sql = "INSERT INTO comments ( caseNumber, username, comment) 
          VALUES ( :caseNumber, :username, :comment)";
          
    $namedParameters = array();
    $namedParameters[':caseNumber'] = $_GET['caseNumber'];
    $namedParameters[':username'] = $_GET['username'];
    $namedParameters[':comment'] = $_GET['comment'];

  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  echo "Comment added!";   
}

        include 'navbarFuncs.php';
?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>MCSO Case Tracking System</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<<<<<<< HEAD
  
  <div>
    <header>
      <h1>Add Comment</h1>
    </header>

    <div>
      <h4>Comment History</h4>
      <?php
=======

    <div id="wrapper">

        

        <?=printNavBar();?>




        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Add Comment for Case # <?php echo $_GET['caseNumber'];?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Comment History</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <?php
>>>>>>> 077b017984179141a0e35572e723283ed62f701b
        $connection = dbConn();
        $com = "Select * FROM `comments` WHERE caseNumber = '" . $_GET['caseNumber'] . "' ORDER BY commentDate ASC";
        $comments = getDataBySQL($com);
        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
        $deputies = getDataBySQL($deputySQL);
        echo "<table table table-striped table-bordered table-hover id='dataTables-example'>"; //limit the size of the comments table
        echo '<col width="150">';
        echo '<col width="150">';
        echo '<col width="500">';
        foreach($comments as $comment){
          echo "<tr>";
              
              foreach($deputies as $deputy){
                if($deputy['username'] == $comment['username']){
                  echo "<td>" . $deputy['rank'] . " " . $deputy['lastname'] . "</td>";
                }
              }
              echo "<td>" . $comment['commentDate'] . "</td>";
              echo "<td>" . $comment['comment'] . "</td>";
          echo "</tr>";
        }
        echo "</table>";
      ?>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
                        
                        <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Comment:</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            
                            <form>
          <textarea rows="4" cols="75" name="comment" /></textarea> <br />
          <input type="hidden" name="caseNumber" value="<?=$_GET['caseNumber']?>" />
          <input type="hidden" name="username" value="<?=$_SESSION['username']?>" />
          <input type="submit" value="Comment On Case" name="commentCase" />
      </form>
                                
                        </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
    <script src="../bower_components/datatables-responsive/js/dataTables.responsive.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
                responsive: true
        });
    });
    </script>




</body>

</html>
