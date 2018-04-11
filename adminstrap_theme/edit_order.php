<?php
// Include config file
include ('config.php');
 
// Define variables and initialize with empty values
$orderid = $ordername = $expid = $expname = $taskid = $tname = "";
$orderid_err = $ordername_err = $expid_err = $expname_err = $taskid_err = $tname_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["orderid"]) && !empty($_POST["orderid"])){
    echo "hr";
    // Get hidden input value
    $expid = $_POST["expid"];
    $orderid = $_POST["orderid"];
     // Validate name
     $input_oname = trim($_POST["ordername"]);
  //check if the field is empty
    if(empty($input_oname)){
        $ordername_err = "Please enter a name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["ordername"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $ordername_err = 'Please enter a valid name.';
    } else{
        $ordername = $input_oname;
    }
$checkbox = $_POST['tname']; // Displays value of checked checkbox.
$checkboxm = $_POST['name'];  

  

      // Check input errors before inserting in database
    if(empty($ordername_err)){
        // Prepare an insert statement
      
        $sql = "UPDATE orders SET ordername=:ordername WHERE orderid=$orderid";
        $sqla = "delete from ordertask where orderid=$orderid";
        $sqlm = "delete from orderuser where orderid=$orderid";
      //prepare sql statements
        if($stmt = $pdo->prepare($sql)){
          if($stmta = $pdo->prepare($sqla)){
            if($stmtm = $pdo->prepare($sqlm)){
          
             // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':ordername', $param_oname);
                       
            // Set parameters
            $param_oname = $ordername;
      
            // Attempt to execute the prepared statement
            if($stmt->execute()){
              
                // Records updated successfully. Redirect to landing page
              if($stmta->execute()){
                 if($stmtm->execute()){
              
                for ($i=0; $i<sizeof($checkbox); $i++)
                   {
             
                      $query1="INSERT INTO ordertask (orderid,taskid) VALUES ($orderid,$checkbox[$i])";  
                      
                     if($stmtb = $pdo->prepare($query1)){
                      
                     if($stmtb->execute()){
                     
                         } else{
                        echo "Something went wrong. Please try again later.";
                             }
                    }
                        else{echo "some error";}
                         
                   }
                   for ($j=0; $j<sizeof($checkboxm); $j++)
                   {
             
                      $queryn="INSERT INTO orderuser (orderid,userid) VALUES ($orderid,$checkboxm[$j])";  
                      
                     if($stmtn = $pdo->prepare($queryn)){
                     
                     if($stmtn->execute()){
                      
                         } else{
                        echo "Something went wrong. Please try again later.";
                             }
                    }
                        else{echo "some error";}
                         // mysql_query($query) or die (mysql_error() );
                   }
                header("location: orders.php");
              //this command is used to exit from the  if statement
                exit();
              }
              }
            } else{
                echo "Something went wrong. Please try again later.";
            }
          }
         }
        }
        // Close statement
        unset($stmt);
    }

} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["orderid"]) && !empty(trim($_GET["orderid"]))){
      
        // Get URL parameter
        $orderid =  trim($_GET["orderid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM orders WHERE orderid = :orderid";
        if($stmt = $pdo->prepare($sql)){
          
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':orderid', $param_orderid);
            
            // Set parameters
            $param_orderid = $orderid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                  
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $ordername = $row["ordername"];
                     //print "query1 = $expname";                 
                } else{
                   
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
    <title>MU Research Dashboard</title>
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
            <li class="active"><a href="index.php">MU Research Dashboard</a></li>
            
            <li><a href="users.php">Users</a></li>
            <li><a href="Task.php">Task</a></li>
            <li><a href="Experiment.php">Experiment</a></li>
            <li><a href="Study.php">Study</a></li>
            
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a>Welcome</a></li>
            <li><a href="login.php">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> MU Research Dashboard<small></small></h1>
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
          <li class="active">MU Research Dashboard</li>
        </ol>
      </div>
    </section>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-3">
            <div class="list-group">
              <a href="index.php" class="list-group-item active main-color-bg">
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> MU Research Dashboard
              </a>
              <a href="Task.php" class="list-group-item"><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> Task <span class="badge"></span></a>
              <a href="Study.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Study <span class="badge"></span></a>
              <a href="Experiment.php" class="list-group-item"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Experiment <span class="badge"></span></a>
              <a href="users.php" class="list-group-item"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users <span class="badge"></span></a>
            </div>

          </div>
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Edit Order</h3>
              </div>
              <div class="panel-body">
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                  <div class="form-group <?php echo (!empty($ordername_err)) ? 'has-error' : ''; ?>">
                    <label>Ordername</label>
                    <input type="text" name="ordername" class="form-control" value="<?php echo $ordername; ?>">
                    <span class="help-block"><?php echo $ordername_err;?></span>
                  </div>
                   <div class="form-group">
                    <label>Associated Tasks</label>
                    <br>
                    <?php  
                    //require_once 'config.php';
                      $id = $_GET["expid"];
                     $ido = $_GET["orderid"];
                    $sql1 = "SELECT a.taskid as taskid,a.tname tname FROM task a,taskexp b where b.expid = '". $id ."' and b.taskid = a.taskid";
                  
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
                     <label>Associated Users</label>
                    <br>
                     <?php
                      $sqlp = "SELECT userid,name FROM users";
                  
                    if($uname = $pdo->query($sqlp)){
                      //check if there were an records in the table
                          
                        while ($rowp = $uname->fetch())
                        {                            
                            echo "<tr><td>";
                            echo "<input type='checkbox' name='name[]' value = ";
                            echo $rowp['userid'];
                            echo " />";
                            //echo " />";
                            echo $rowp['name'];
                            echo "</td></tr><br/>";
                        }
                    }
                     ?>
                  </div>
                  <input type="hidden" name="expid" value="<?php echo $id; ?>"/>
                  <input type="hidden" name="orderid" value="<?php echo $ido; ?>"/>
                  <input type="submit" class="btn btn-default" value="Submit">
                  <a href="orders.php?expid=<?php echo $id; ?>" class="btn btn-default">Cancel</a>
                </form> 
              </div>
              </div>
          </div>
        </div>
      </div>  
    </section>

    
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
