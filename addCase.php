<!DOCTYPE html>
<?php
//Check the session and connect to the database
session_start();
include 'dbConn.php';
$connection = dbConn();
if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
    header("Location: index.php");
    
}


if (isset($_GET['addCase'])) {  //admin submitted form to add product
if(strcmp($_GET['caseNumber'],"")==0){
  echo "<h2><font color=red>Case Number cannot be blank.</font></h2>";
}else{
  try{
    $conn = dbConn();
    //Check authentication Here
    
    $sql = "INSERT INTO `case` ( reportDate, caseNumber, crime, location, reportingParty, victim, suspect, reportingDeputy, flaggedCase, agCrime, status, assignedTo, unit, assignedBy, followUpDate, complaintAction, property, evidence, cash, narcotics, weapons, summary)
      VALUES ( :reportDate, :caseNumber, :crime, :location, :reportingParty, :victim, :suspect, :reportingDeputy, :flaggedCase, :agCrime, :status, :assignedTo, :unit, :assignedBy, :followUpDate, :complaintAction, :property, :evidence, :cash, :narcotics, :weapons, :summary)";
      
      $namedParameters = array();
      $namedParameters[':reportDate'] = $_GET['reportDate'];
      $namedParameters[':caseNumber'] = $_GET['caseNumber'];
      $namedParameters[':crime'] = $_GET['crime'];
      $namedParameters[':location'] = $_GET['location'];
      $namedParameters[':reportingParty'] = $_GET['reportingParty'];
      $namedParameters[':victim'] = $_GET['victim'];
      $namedParameters[':suspect'] = $_GET['suspect'];
      $namedParameters[':reportingDeputy'] = $_GET['reportingDeputy'];
      $namedParameters[':flaggedCase'] = $_GET['flaggedCase'];
      $namedParameters[':agCrime'] = $_GET['agCrime'];
      $namedParameters[':status'] = $_GET['status'];
      $namedParameters[':assignedTo'] = $_GET['assignedTo'];
      $namedParameters[':unit'] = $_GET['unit'];
      $namedParameters[':assignedBy'] = $_GET['assignedBy'];
      $namedParameters[':followUpDate'] = $_GET['followUpDate'];
      $namedParameters[':complaintAction'] = $_GET['complaintAction'];
      $namedParameters[':property'] = $_GET['property'];
      $namedParameters[':evidence'] = $_GET['evidence'];
      $namedParameters[':cash'] = $_GET['cash'];
      $namedParameters[':narcotics'] = $_GET['narcotics'];
      $namedParameters[':weapons'] = $_GET['weapons'];
      $namedParameters[':summary'] = $_GET['summary'];
      
      
      $statement = $conn->prepare($sql);
      $statement->execute($namedParameters);  
    
    echo "Case has been added.";   
    header("Location: main.php");
  }catch (Exception $e){
    $hasError = true;
    echo "<h2><font color=red>Caught exception. Check your form. Duplicate Case Number?</font></h2>";
    function displayError(){
      echo '<p>Error Code for the squints: ' . $e->getMessage() . "\n";
    }
  }
}
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

        <?=printNavBar();?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Forms</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            New Case Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h1>Report Information</h1>
                                    <form role="form">
                                        <div class="form-group input-group date" id="datetimepicker1">
                                            <label>Report Date:</label>
                                            <input type="date" class="form-control" name="reportDate">
                                            <!--<p class="help-block">Example block-level help text here.</p> -->
                                        </div>

                                        <div class="form-group">
                                            <label>Case Number: </label>
                                            <input type="text" class="form-control" placeholder="Enter Case #" name="caseNumber">
                                        </div>
                                        <div class="form-group">
                                            <label>Crime: </label>
                                            <input type="text" class="form-control" placeholder="Enter Crime" name="crime">
                                        </div>
                                        <div class="form-group">
                                            <label>Location: </label>
                                            <input type="text" class="form-control" placeholder="Enter Location" name="location">
                                        </div>
                                        <div class="form-group">
                                            <label>Reporting Party: </label>
                                            <input type="text" class="form-control" placeholder="Enter Reporting Party" name="reportingParty">
                                        </div>
                                        <div class="form-group">
                                            <label>Victim: </label>
                                            <input type="text" class="form-control" placeholder="Enter Victim" name="victim">
                                        </div>
                                        <div class="form-group">
                                            <label>Suspect: </label>
                                            <input type="text" class="form-control" placeholder="Enter Suspect" name="suspect">
                                        </div>
                                        <div class="form-group">
                                            <label>Reporting Deputy: </label>
                                            <select class="form-control" name="reportingDeputy">
                                                <?php
                                                    $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                                                    $deputies = getDataBySQL($deputySQL);
                                                        foreach($deputies as $deputy){
                                                            echo '<option value="' . $deputy['username'] . '">' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                                                        }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Checkboxes</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="flaggedCase">Flagged Case
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name=agCrime>Ag Crime
                                                </label>
                                            </div>
                                        </div>
                                        
                                        
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    <h1>Case Assignment Information</h1>
                                    <div class="form-group">
                                        <label>Status:</label>
                                        <select class="form-control" name="status">
                                            <option value="Active" >Active</option>
                                            <option value="Warrant" >Warrant</option>
                                            <option value="Closed" >Closed</option>
                                            <option value="Suspended" >Suspended</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Assigned To:</label>
                                        <select class="form-control" name="assignedTo">
                                            <?php
                                                $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                                                $deputies = getDataBySQL($deputySQL);
                                                foreach($deputies as $deputy){
                                                    echo '<option value="' . $deputy['username'] . '">' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit:</label>
                                        <select class="form-control" name="unit">
                                            <option value="SV-SA" >DV-SA</option>
                                            <option value="Narcotics" >Narcotics </option>
                                            <option value="Persons" >Persons</option>
                                            <option value="Property" >Property </option>
                                            <option value="SED" >SED </option>
                                            <option value="MADCAT" >MADCAT </option>
                                            <option value="AG Unit" >AG Unit </option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="disabledSelect">Assigned By</label>
                                        <select id="disabledSelect" class="form-control">
                                            <option><?=$_SESSION['rank']?> <?=$_SESSION['lastname']?><input type="hidden" name="assignedBy" value="<?=$_SESSION['username']?>"/></option>
                                        </select>
                                    </div>
                                    
                                    <div class="from-group">
                                        <label>Follow Up Date:</label>
                                        <input type="date" class="form-control" name="followUpDate">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Complaint Action:</label>
                                        <select class="form-control" name="complaintAction">
                                            <option value="To DA" >To DA</option>
                                            <option value="Pending Court" >Pending Court</option>
                                            <option value="Warrant Issued" >Warrant Issued</option>
                                            <option value="Other" >Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Property:</label>
                                        <input type="checkbox" name="property" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label>Evidence:</label>
                                        <input type="checkbox" name="evidence" value="1">
                                    </div>
                                    
                                    
                                    <h2>Siezures</h2>
                                    <div class="form-group">
                                        <label>Cash:</label>
                                        <input type="checkbox" name="cash" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label>Narcotics:</label>
                                        <input type="checkbox" name="narcotics" value="1">
                                    </div>
                                    <div class="form-group">
                                        <label>Weapons:</label>
                                        <input type="checkbox" name="weapons" value="1">
                                    </div>
                                    
                                        
                                        
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                            
                            <div class="row">
                                <div class = "col-md-12">
                                    <div class="form-group">
                                        <label>Summary</label>
                                        <textarea class="form-control" rows="10" name="summary"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-default" value="Submit Case" name="addCase">Submit Button</button>
                                    <button type="reset" class="btn btn-default">Reset Button</button>
                                    </form>
                                </div>
                            </div>
                            <!-- /.row for summary -->
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
<?php if($hasError){
        displayError();
      }
      ?>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

</body>

</html>
