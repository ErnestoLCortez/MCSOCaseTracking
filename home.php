<!DOCTYPE html>
<?php
session_start();

if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}

include 'dbConn.php';

$connection = dbConn();

function displayMyCases(){
  /*
  * SQL queries to retrieve pertinent cases
  */
    if($_SESSION['rank'] == "Admin" || $_SESSION['rank'] == "Commander"){
      $sql = "Select * FROM `case` WHERE `active` = 1 ORDER BY entryDate DESC";
    }else{
      $sql = "Select * FROM `case` a WHERE a.assignedTo = '" . $_SESSION['username'] . "' ORDER BY entryDate DESC";
    }
    
    $records = getDataBySQL($sql);
    
    // $commentSQL = "Select * FROM comments ";
    // $comments = getDataBySQL($commentSQL);

     //Using Form Buttons
         echo "<table width='100%' class='table table-striped table-bordered table-hover' id='dataTables-example'>";
         echo "<thead></tr>"; //Start headers
         echo "<th>Case Number</th>";		
         echo "<th>Victim</th>";		
         echo "<th>Crime</th>";		
         echo "<th>Follow Up Date</th>";		
         echo "<th>Complaint Action</th>";
         echo "<th>Comments</th>";
         echo "</tr></thead>";  //End headers
         echo "<tbody>"; //Start table body
        foreach ($records as $record) {
          echo "<tr>"; 
          echo "<td>" . $record['caseNumber'] . "</td>"; 
          echo "<td>" . $record['victim'] . "</td>";
          echo "<td>" . $record['crime'] . "</td>";
          echo "<td>" . $record['followUpDate'] . "</td>";
          echo "<td>" . $record['complaintAction'] . "</td>";
              $com = "Select * FROM `comments` a WHERE a.caseNumber = '" . $record['caseNumber'] . "' ORDER BY commentDate DESC";
              $comments = getDataBySQL($com);
              $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
              $deputies = getDataBySQL($deputySQL);
          echo "<td><table border=1>"; //Limit the size of the comments table
          echo '<col width="150">';
          echo '<col width="150">';
          echo '<col width="500">';
          $atFive = 0;
            foreach($comments as $comment){
              if($atFive == 5){
                break;
              }
              echo "<tr>";
              foreach($deputies as $deputy){
                if($deputy['username'] == $comment['username']){
                  echo "<td>" . $deputy['rank'] . " " . $deputy['lastname'] . "</td>";
                  $atFive += 1;
                }
                
              }
              echo "<td>" . $comment['commentDate'] . "</td>";
              echo "<td>" . $comment['comment'] . "</td>";
              echo "</tr>";
            }
            echo "</tbody>"; //End table body
          echo "</table>";
          echo "</td></tr>";
          //UPDATE CASE BUTTON
          echo "<td> <form action=updateCase.php>";
          echo "<input type='hidden' name='caseNumber' value='".$record['caseNumber'] . "'/>";
          echo "<input type='submit' value='View Case'/></form> </td>";
          
          //COMMENT ON CASE BUTTON
          echo "<td> <form action=commentCase.php>";
          echo "<input type='hidden' name='caseNumber' value='".$record['caseNumber'] . "'/>";
          echo "<input type='submit' value='Comment On Case'/></form> </td>";
          
          //DELETE CASE BUTTON
          echo "<td> <form action=archiveCase.php>";
          echo "<input type='hidden' name='caseNumber' value='".$record['caseNumber'] . "'/>";
          echo "<input type='submit' value='Finalize/Archive Case'/></form> </td>";
          echo "</tr>";
          echo "</tr>";
        } //endForeach
        echo "</table>";
}

?>


<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="home.php">MCSO Case Tracking  v0.01</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="users.php"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="home.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="addCases.php"><i class="fa fa-edit fa-fw"></i> New Case</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Analytics & Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="/pages/flot.html">In-Progress</a>
                                </li>
                                <li>
                                    <a href="/pages/morris.html">In-Progress</a>
                                </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="searchCase.php"><i class="fa fa-search fa-fw"></i> Advanced Search</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>







        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Cases at a Glance</h3>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="dataTable_wrapper">
                                <?=displayMyCases()?>
                            </div>
                            <!-- /.table-responsive -->
                            
                        </div>
                        <!-- /.panel-body -->
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
