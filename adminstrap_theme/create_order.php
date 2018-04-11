<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$orderid = $taskid = $userid = $oname = "";
$ordeid_err = $taskid_err = $oname_err = "";
$row = $row1 = ""; 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
     // Validate name
    $input_oname = trim($_POST["oname"]);
  //check if the field is empty
    if(empty($input_oname)){
        $oname_err = "Please enter a name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["oname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $oname_err = 'Please enter a valid name.';
    } else{
        
        $oname = $input_oname;
    }
  $id1 = $_POST['expid'];
  print "ss = $id1";
    // Check input errors before inserting in database
  if(empty($oname_err)){
    if(isset($id1) && !empty($id1)){
        
        // Prepare an insert statement
      
         $sql = "INSERT INTO orders (ordername) VALUES (:oname)";
          print "query = $sql";
        if($stmt = $pdo->prepare($sql)){
                      // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':oname', $param_oname);
                     
            // Set parameters
            $param_oname = $oname;
           
            // Attempt to execute the prepared statement
            if($stmt->execute()){
              echo "ick";
               // Records created successfully. Redirect to data page
               // header("location: Task.php");
              //$conn = mysql_connect('localhost', 'kausthub', '1234');
              $query = "SELECT orderid FROM orders WHERE ordername = '". $oname ."'";
              $result = $pdo->query($query);
              $row1 = $result->fetch();
              echo $row1;
              //this command is used to exit from the  if statement 
                //exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
// Make a MySQL Connection
      
//mysql_connect("localhost", "kausthub", "1234") or die(mysql_error());
//mysql_select_db("test") or die(mysql_error());
//if (isset($_POST['tname'])){
$checkbox = $_POST['tname']; // Displays value of checked checkbox.
$checkboxa = $_POST['uname'];
//}
  
  
//foreach ($checkbox as $color){ 
  // echo $color."<br />";
//}
echo sizeof($checkbox);
  echo sizeof($checkboxa);
//echo sizeof($color);
 $queryo="INSERT INTO orderexp (orderid,expid) VALUES ($row1[0],$id1)";  
  print "query1 = $queryo";    
 $stmto = $pdo->prepare($queryo);
 if($stmto->execute()){
   echo "bar";
    for ($i=0; $i<sizeof($checkbox); $i++)
        {
             
            $query1="INSERT INTO ordertask (orderid,taskid) VALUES ($row1[0],$checkbox[$i])";  
            print "query1 = $query1";      
        //echo "fff";
            if($stmt1 = $pdo->prepare($query1)){
                echo "dd";
            //$param_ename = $ename;
           
            // Attempt to execute the prepared statement
            if($stmt1->execute()){
             echo "prty";
                // Records created successfully. Redirect to data page
                //header("location: Task.php");
              //this command is used to exit from the  if statement 
               // exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
      else{echo "some error";}
           // mysql_query($query) or die (mysql_error() );
        }
  for ($j=0; $j<sizeof($checkboxa); $j++)
        {
             
            $query2="INSERT INTO orderuser (orderid,userid) VALUES ($row1[0],$checkboxa[$j])";  
            print "query2 = $query2";      
        //echo "fff";
            if($stmt2 = $pdo->prepare($query2)){
                echo "ff";
            //$param_ename = $ename;
           
            // Attempt to execute the prepared statement
            if($stmt2->execute()){
             echo "prty1";
                // Records created successfully. Redirect to data page
                //header("location: Experiment.php");
              //this command is used to exit from the  if statement 
                //exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
      else{echo "some error";}
           // mysql_query($query) or die (mysql_error() );
        }
   header("location: Experiment.php");
  }
}
    echo "Complete";

    // Close connection
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
  </head>
  <body>
 <style>
    .row:after {
    content: "";
    display: table;
    clear: both;
}
</style>
    <nav class="navbar navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php">Dashboard</a></li>
            
            <li><a href="users.php">Users</a></li>
            <li><a href="Task.php">Task</a></li>
            <li><a href="Experiment.php">Experiment</a></li>
            <li><a href="Study.php">Study</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#">Welcome, Prajeth</a></li>
            <li><a href="login.html">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard <small>Manage Your Site</small></h1>
          </div>
          <div class="col-md-2">
            <div class="dropdown create">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Create Content
                <span class="caret"></span>
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a type="button" href="create_user.php">Add user</a></li>
                <li><a type="button" href="create_task.php">Add Task</a></li>
                <li><a type="button" href="create_exp.php">Add Experiment</a></li>
                 <li><a type="button" href="create_study.php">Add Study</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </header>

    <section id="breadcrumb">
      <div class="container">
        <ol class="breadcrumb">
          <li class="active">Dashboard</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="index.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
              </a>
              <a href="Task.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Task <span class="badge">12</span></a>
              <a href="Study.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Study <span class="badge">33</span></a>
              <a href="Experiment.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Experiment <span class="badge">33</span></a>
              <a href="users.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge">203</span></a>
            </div>

            <div class="well">
              <h4>Disk Space Used</h4>
              <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%;">
                      60%
              </div>
            </div>
            <h4>Bandwidth Used </h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%;">
                    40%
            </div>
          </div>
            </div>
          </div>
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Website Overview</h3>
              </div>
              <div class="panel-body">
                 <br>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group <?php echo (!empty($oname_err)) ? 'has-error' : ''; ?>">
                    <label>Ordername</label>
                    <input type="text" name="oname" class="form-control" value="<?php echo $oname; ?>">
                    <span class="help-block"><?php echo $oname_err;?></span>
                  </div>
                  <div class="form-group">
                    <label>instruction</label>
                    <br>
                    <?php  
                    require_once 'config.php';
                    $id = $_GET["expid"];
                    $sql = "SELECT a.taskid as taskid,a.tname tname FROM task a,taskexp b where b.expid = '". $id ."' and b.taskid = a.taskid";
                    print "query = $sql";
                    if($tname = $pdo->query($sql)){
                      //check if there were an records in the table
    
                        while ($row = $tname->fetch())
                        {                            
                            echo "<tr><td>";
                            echo "<input type='checkbox' name='tname[]' value = ";
                            echo $row['taskid'];
                            echo " />";
                            //echo " />";
                            echo $row['tname'];
                            echo "</td></tr><br/>";
                        }
                    }
                     ?>
                  </div>
                  <div class="form-group">
                    <label>instruction</label>
                    <br>
                    <?php  
                    require_once 'config.php';
                    $sql = "SELECT userid,name FROM users";
                    if($tname = $pdo->query($sql)){
                      //check if there were an records in the table
    
                        while ($row = $tname->fetch())
                        {                            
                            echo "<tr><td>";
                            echo "<input type='checkbox' name='uname[]' value = ";
                            echo $row['userid'];
                            echo " />";
                            //echo " />";
                            echo $row['name'];
                            echo "</td></tr><br/>";
                        }
                    }
                     ?>
                  </div>
                  <input type="hidden" name="expid" value="<?php echo $id; ?>"/>
                  <input type="submit" class="btn btn-default" value="Submit">
                  <a href="readexp.php" class="btn btn-default">Cancel</a>
                </form> 
             </div>
              </div>

          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer>
      <script>
     CKEDITOR.replace( 'editor1' );
 </script>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>