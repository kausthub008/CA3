<?php
// Include config file
include ('config.php');
 
// Define variables and initialize with empty values
$expid = $expname = $taskid = $tname = $tinstruction = $tlink = "";
$expid_err = $expname_err = $taskid_err = $tname_err = $tinstruction_err = $tlink_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["expid"]) && !empty($_POST["expid"])){
  
    // Get hidden input value
    $expid = $_POST["expid"];
     // Validate name
     $input_ename = trim($_POST["expname"]);
  //check if the field is empty
    if(empty($input_ename)){
        $expname_err = "Please enter a name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["expname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $expname_err = 'Please enter a valid name.';
    } else{
        $expname = $input_ename;
    }
$checkbox = $_POST['tname']; // Displays value of checked checkbox.
$checkboxm = $_POST['name'];  
echo sizeof($checkbox);
echo sizeof($checkboxm);
  

      // Check input errors before inserting in database
    if(empty($expname_err)){
        // Prepare an insert statement
      
        $sql = "UPDATE experiment SET expname=:expname WHERE expid=$expid";
        $sqla = "delete from taskexp where expid=$expid";
        
        //$sqlb ="INSERT INTO taskexp (expid,taskid) VALUES ($expid,$checkbox[$i])";
          echo "dd";
      print "queries = $sql";
      print "queries $sqla";
      
        if($stmt = $pdo->prepare($sql)){
          if($stmta = $pdo->prepare($sqla)){
            
          
             // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':expname', $param_ename);
                       
            // Set parameters
            $param_ename = $expname;
      
            // Attempt to execute the prepared statement
            if($stmt->execute()){
              
                // Records updated successfully. Redirect to landing page
              if($stmta->execute()){
                 
              
                for ($i=0; $i<sizeof($checkbox); $i++)
                   {
             
                      $query1="INSERT INTO taskexp (expid,taskid) VALUES ($expid,$checkbox[$i])";  
                       print "query1 = $query1";      
                        //echo "fff";
                     if($stmtb = $pdo->prepare($query1)){
                       echo "dd";
                     if($stmtb->execute()){
                       echo "prty";
                         // exit();
                         } else{
                        echo "Something went wrong. Please try again later.";
                             }
                    }
                        else{echo "some error";}
                         // mysql_query($query) or die (mysql_error() );
                   }
                header("location: Experiment.php?studyid=$ids");
              //this command is used to exit from the  if statement
                exit();
              
              }
            } else{
                echo "Something went wrong. Please try again later.";
            }
          
         }
        }
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    //unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["expid"]) && !empty(trim($_GET["expid"]))){
      
        // Get URL parameter
        $expid =  trim($_GET["expid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM experiment WHERE expid = :expid";
        if($stmt = $pdo->prepare($sql)){
          
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':expid', $param_expid);
            
            // Set parameters
            $param_expid = $expid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                  
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $expname = $row["expname"];
                     //print "query1 = $expname";                 
                } else{
                    
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        //unset($pdo);
    }  else{
      
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
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
                
                 <?php
                  $id = $_GET['expid'];
                  if(isset($id) && !empty($id)){
                  //echo "ff";
                  //require_once 'config.php';
                    
                      $sql ="SELECT b.taskid as TaskID,b.tname as TaskName FROM taskexp a,task b where a.expid =". $id ." and a.taskid=b.taskid";
  
                        //If the exception is thrown, this text will not be shown
                        //echo 'If you see this, the number is 1 or below';
                  echo "<table border='1' style='float: left'>
                  <tr>
                  <th>TaskID</th>
                  <th>TaskName</th>
                  </tr>";
                    //print "query1 = $sql";
                 if($result = $pdo->query($sql)){
                 //echo"dd";
                  while($row = $result->fetch())
                  {
                      echo "<tr>";
                      echo "<td>" . $row['TaskID'] . "</td>";
                      echo "<td>" . $row['TaskName'] . "</td>";
                      echo "</tr>";
                   }
                   //echo "<br>";
                    }                  
                    echo "</table>";
                }else{
                // Check existence of id parameter
                if(empty(trim($_GET["expid"]))){
                // URL doesn't contain id parameter. Redirect to error page
                 header("location: error.php");
                exit();
                 }
                }
                //
               ?>
                <br>
                <br>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                  <br>
                  <div class="form-group <?php echo (!empty($expname_err)) ? 'has-error' : ''; ?>">
                    <br>
                    <label>name</label>
                    <input type="text" name="expname" class="form-control" value="<?php echo $expname; ?>">
                    <span class="help-block"><?php echo $expname_err;?></span>
                  </div>
                   <div class="form-group">
                    <label>Associated Tasks</label>
                    <br>
                    <?php  
                    //require_once 'config.php';
                    $sql1 = "SELECT taskid,tname FROM task";
                   //echo "dd";
                    if($tname = $pdo->query($sql1)){
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
                  <input type="hidden" name="expid" value="<?php echo $id; ?>"/>
                  <input type="hidden" name="studyid" value="<?php echo $ids; ?>"/>                  
                  <input type="submit" class="btn btn-default" value="Submit">
                  <a href="Experiment.php" class="btn btn-default">Cancel</a>
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
