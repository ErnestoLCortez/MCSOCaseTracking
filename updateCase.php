<?php
// echo "<a href='main.php'>Home</a>";
include 'dbConn.php';
$connection = dbConn();
$hasUpdate = false;

include 'navbarFuncs.php';

//Check for session. Kick if not logged in.
// if (!isset($_SESSION['username'])) {  //checks whether user has logged in
    
//     header("Location: index.php");
    
// }

//Pull case information
function getCaseByID(){
  $conn = dbConn();
  $sql = "SELECT * FROM `case` WHERE caseNumber = :caseNumber";
  $namedParameters = array();
  $namedParameters[':caseNumber'] = $_GET['caseNumber'];
  $statement = $conn->prepare($sql);    
  $statement->execute($namedParameters);
  $record = $statement->fetch();
  return $record;
}

if (isset($_GET['updateCase'])) {  //submit the updated case information
  //Check authentication Here
  // $conn = dbConn();
  $sql = "UPDATE `case`
          SET reportDate = :reportDate,
          caseNumber = :caseNumber,
          crime = :crime,
          location = :location,
          reportingParty = :reportingParty,
          victim = :victim,
          suspect = :suspect,
          reportingDeputy = :reportingDeputy,
          flaggedCase = :flaggedCase,
          agCrime = :agCrime,
          status = :status,
          assignedTo = :assignedTo,
          unit = :unit,
          assignedBy = :assignedBy,
          followUpDate = :followUpDate,
          complaintAction = :complaintAction,
          property = :property,
          evidence = :evidence,
          cash = :cash,
          narcotics = :narcotics,
          weapons = :weapons,
          summary = :summary
          WHERE caseNumber = :caseNumber";
    
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
    $namedParameters[':caseNumber'] = $_GET['caseNumber'];
    
    
  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  $hasUpdate = true;

}

if (isset($_GET['archiveCase'])) {  //submit the finalize case information to be archived
  //Check authentication Here
  // $conn = dbConn();
  $sql = "UPDATE `case`
          SET reportDate = :reportDate,
          active = 0,
          caseNumber = :caseNumber,
          crime = :crime,
          location = :location,
          reportingParty = :reportingParty,
          victim = :victim,
          suspect = :suspect,
          reportingDeputy = :reportingDeputy,
          flaggedCase = :flaggedCase,
          agCrime = :agCrime,
          status = :status,
          assignedTo = :assignedTo,
          unit = :unit,
          assignedBy = :assignedBy,
          followUpDate = :followUpDate,
          complaintAction = :complaintAction,
          property = :property,
          evidence = :evidence,
          cash = :cash,
          narcotics = :narcotics,
          weapons = :weapons,
          summary = :summary
          WHERE caseNumber = :caseNumber";
    
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
    $namedParameters[':caseNumber'] = $_GET['caseNumber'];
    
    
  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  $hasUpdate = true;

}

if(isset($_GET['activateCase'])){
    $sql = "UPDATE `case`
          SET reportDate = :reportDate,
          active = 1,
          caseNumber = :caseNumber,
          crime = :crime,
          location = :location,
          reportingParty = :reportingParty,
          victim = :victim,
          suspect = :suspect,
          reportingDeputy = :reportingDeputy,
          flaggedCase = :flaggedCase,
          agCrime = :agCrime,
          status = :status,
          assignedTo = :assignedTo,
          unit = :unit,
          assignedBy = :assignedBy,
          followUpDate = :followUpDate,
          complaintAction = :complaintAction,
          property = :property,
          evidence = :evidence,
          cash = :cash,
          narcotics = :narcotics,
          weapons = :weapons,
          summary = :summary
          WHERE caseNumber = :caseNumber";
    
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
    $namedParameters[':caseNumber'] = $_GET['caseNumber'];
    
    
  $conn = dbConn();    
  $statement = $conn->prepare($sql);
  $statement->execute($namedParameters);  
  
  $hasUpdate = true;
}

?>

<!DOCTYPE html>
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
  <?php $case = getCaseByID()?>
  <div id="wrapper">

        <?=printNavBar();?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div>
      <?php if($hasUpdate){
        echo "<br><font color=red><h1>Case has been updated.</h1></font>";
      }else{
      echo '<h1 class="page-header">Update Case</h1>';
      }?>
    </div>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Update Case Form
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    
                                    <h1>Report Information</h1>
                                    <form role="form">
                                        <div class="form-group input-group date" id="datetimepicker1">
                                            <label>Report Date:</label>
                                            <input type="date" class="form-control" name="reportDate" value="<?=$case['reportDate']?>">
                                            <!--<p class="help-block">Example block-level help text here.</p> -->
                                        </div>

                                        <div class="form-group">
                                            <label>Case Number: </label>
                                            <input type="text" class="form-control" placeholder="Enter Case #" name="caseNumber" value="<?=$case['caseNumber']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Crime: </label>
                                            <input type="text" class="form-control" placeholder="Enter Crime" name="crime" value="<?=$case['crime']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Location: </label>
                                            <input type="text" class="form-control" placeholder="Enter Location" name="location" value="<?=$case['location']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Reporting Party: </label>
                                            <input type="text" class="form-control" placeholder="Enter Reporting Party" name="reportingParty" value="<?=$case['reportingParty']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Victim: </label>
                                            <input type="text" class="form-control" placeholder="Enter Victim" name="victim" value="<?=$case['victim']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Suspect: </label>
                                            <input type="text" class="form-control" placeholder="Enter Suspect" name="suspect" value="<?=$case['suspect']?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Reporting Deputy: </label>
                                            <select name="reportingDeputy">
                       <?php
                        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['username'] . '"';
                          if($deputy['username'] == $case['reportingDeputy']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Checkboxes</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name="flaggedCase" <?php if($case['flaggedCase'] == "1"){echo "checked";}?>>Flagged Case
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" value="1" name=agCrime <?php if($case['agCrime'] == "1"){echo "checked";}?>>Ag Crime
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
                                            <option value="Active"  <?php if($case['status'] == "Active"){echo "selected";}?>>Active</option>
                                            <option value="Warrant"  <?php if($case['status'] == "Warrant"){echo "selected";}?>>Warrant</option>
                                            <option value="Closed"  <?php if($case['status'] == "Closed"){echo "selected";}?>>Closed</option>
                                            <option value="Suspended"  <?php if($case['status'] == "Suspended"){echo "selected";}?>>Suspended</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Assigned To:</label>
                                        <select name="assignedTo">
                       <?php
                        $deputySQL = "SELECT * FROM `users` WHERE `active` = 1 ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['username'] . '"';
                          if($deputy['username'] == $case['assignedTo']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                    </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Unit:</label>
                                        <select class="form-control" name="unit">
                                            <option value="SV-SA" <?php if($case['unit'] == "SV-SA"){echo "selected";}?>>DV-SA</option>
                                            <option value="Narcotics"  <?php if($case['unit'] == "Narcotics"){echo "selected";}?>>Narcotics </option>
                                            <option value="Persons"  <?php if($case['unit'] == "Persons"){echo "selected";}?>>Persons</option>
                                            <option value="Property"  <?php if($case['unit'] == "Property"){echo "selected";}?>>Property </option>
                                            <option value="SED" <?php if($case['unit'] == "SED"){echo "selected";}?>>SED </option>
                                            <option value="MADCAT"  <?php if($case['unit'] == "MADCAT"){echo "selected";}?>>MADCAT </option>
                                            <option value="AG Unit"  <?php if($case['unit'] == "AG Unit"){echo "selected";}?>>AG Unit </option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="disabledSelect">Assigned By</label>
                                        <select id="disabledSelect" class="form-control">
                                            <?php
                        $deputySQL = "SELECT * FROM `users` ORDER BY lastname ASC";
                        $deputies = getDataBySQL($deputySQL);
                        foreach($deputies as $deputy){
                          echo '<option value="' . $deputy['username'] . '"';
                          if($deputy['username'] == $case['assignedBy']){
                            echo " selected ";
                          }
                          echo ' >' . $deputy['rank'] . ' ' . $deputy['lastname'] . '</option>';
                        }
                       ?>
                                        </select>
                                    </div>
                                    
                                    <div class="from-group">
                                        <label>Follow Up Date:</label>
                                        <input type="date" class="form-control" name="followUpDate" value="<?=$case['followUpDate']?>">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Complaint Action:</label>
                                        <select class="form-control" name="complaintAction">
                                            <option value="To DA" <?php if($case['complaintAction'] == "To DA"){echo "selected";}?>>To DA</option>
                       <option value="Pending Court" <?php if($case['complaintAction'] == "Pending Court"){echo "selected";}?>>Pending Court</option>
                       <option value="Warrant Issued" <?php if($case['complaintAction'] == "Warrant Issued"){echo "selected";}?>>Warrant Issued</option>
                       <option value="Other" <?php if($case['complaintAction'] == "Other"){echo "selected";}?>>Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Property:</label>
                                        <input type="checkbox" name="property" value="1" <?php if($case['property'] == "1"){echo "checked";}?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Evidence:</label>
                                        <input type="checkbox" name="evidence" value="1" <?php if($case['evidence'] == "1"){echo "checked";}?>>
                                    </div>
                                    
                                    
                                    <h2>Siezures</h2>
                                    <div class="form-group">
                                        <label>Cash:</label>
                                        <input type="checkbox" name="cash" value="1" <?php if($case['cash'] == "1"){echo "checked";}?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Narcotics:</label>
                                        <input type="checkbox" name="narcotics" value="1" <?php if($case['narcotics'] == "1"){echo "checked";}?>>
                                    </div>
                                    <div class="form-group">
                                        <label>Weapons:</label>
                                        <input type="checkbox" name="weapons" value="1" <?php if($case['weapons'] == "1"){echo "checked";}?>>
                                    </div>
                                    
                                        
                                        
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                            
                            <div class="row">
                                <div class = "col-md-12">
                                    <div class="form-group">
                                        <label>Summary</label>
                                        <textarea class="form-control" rows="10" name="summary"><?php echo $case['summary'];?></textarea>
                                    </div>
                                    <input type="hidden" name="caseNumber" value="<?php echo $case['caseNumber']?>" />
                                    <button type="submit" class="btn btn-default" value="Update Case" name="updateCase">Update Case</button>
                                    <?php if($case['active']==1){
                                        echo '<button type="submit" class="btn btn-default" value="Archive Case" name="archiveCase">Archive Case</button>';
                                    }else{
                                        echo '<button type="submit" class="btn btn-default" value="Activate Case" name="activateCase">Re-Activate Case</button>';
                                    } ?>
                                    
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