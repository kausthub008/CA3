<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$taskid = $tname = $tinstruction = $tlink = "";
$taskid_err = $tname_err = $tinstruction_err = $tlink_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["taskid"]) && !empty($_POST["taskid"])){
    // Get hidden input value
    $taskid = $_POST["taskid"];
     // Validate name
     $input_tname = trim($_POST["tname"]);
  //check if the field is empty
    if(empty($input_tname)){
        $name_err = "Please enter a name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["tname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $tname_err = 'Please enter a valid name.';
    } else{
        $tname = $input_tname;
    }
    
   // Validate tinstruction
    $input_tinstruction = trim($_POST["tinstruction"]);
  //check if the field is empty
    if(empty($input_tinstruction)){
        $tinstruction_err = 'Please enter an instruction.';     
    } 
    else{
        $tinstruction = $input_tinstruction;
    }
    
    // Validate salary
    $input_tlink = trim($_POST["tlink"]);
  //check if the field is empty
    if(empty($input_tlink)){
        $tlink_err = "Please enter the link.";
      //check if the entered value is a positive digit
    } else{
       $tlink = $input_tlink;
    }
    
  echo $tname_err;
  echo $tinstruction_err;
  echo $tlink_err;

      // Check input errors before inserting in database
    if(empty($tname_err) && empty($tinstruction_err) && empty($tlink_err)){
        // Prepare an insert statement
      
        $sql = "UPDATE task SET tname=:tname, tinstruction=:tinstruction, tlink=:tlink WHERE taskid=:taskid";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':tname', $param_tname);
            $stmt->bindParam(':tinstruction', $param_tinstruction);
            $stmt->bindParam(':tlink', $param_tlink);
            $stmt->bindParam(':taskid', $param_taskid);
            
            // Set parameters
            $param_tname = $tname;
            $param_tinstruction = $tinstruction;
            $param_tlink = $tlink;
            $param_taskid = $taskid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: Task.php");
              //this command is used to exit from the  if statement
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["taskid"]) && !empty(trim($_GET["taskid"]))){
        // Get URL parameter
        $taskid =  trim($_GET["taskid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM task WHERE taskid = :taskid";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':taskid', $param_taskid);
            
            // Set parameters
            $param_taskid = $taskid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $tname = $row["tname"];
                    $tinstruction = $row["tinstruction"];
                    $tlink = $row["tlink"];
                  
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
        unset($pdo);
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> MU Research Dashboard <small></small></h1>
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
                <h3 class="panel-title">Edit the Task</h3>
              </div>
              <div class="panel-body">
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                  <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>Tasname</label>
                    <input type="text" name="tname" class="form-control"  placeholder="name" value="<?php echo $tname; ?>">
                    <span class="help-block"><?php echo $name_err;?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($tinstruction_err)) ? 'has-error' : ''; ?>">
                    <label>Task Instruction</label>
                    <input type="text" name="tinstruction" class="form-control" placeholder="Add Some Tags..." value="<?php echo $tinstruction; ?>">
                     <span class="help-block"><?php echo $tinstruction_err;?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($tlink_err)) ? 'has-error' : ''; ?>">
                    <label>Tasklink</label>
                    <input type="text" name="tlink"class="form-control" placeholder="Add Meta Description..." value="<?php echo $tlink; ?>">
                    <span class="help-block"><?php echo $tlink_err;?></span>
                  </div>
                  <input type="hidden" name="taskid" value="<?php echo $taskid; ?>"/>
                  <input type="submit" class="btn btn-default" value="Submit">
                  <a href="Task.php" class="btn btn-default">Cancel</a>
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
