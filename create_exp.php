<?php
//call the default.php page which takes care of unexpected exit from browser and brings back user to same state once he logs in
        include("default.php");  
 ?>
<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$expid = $taskid = $userid = $ename = "";
$expid_err = $taskid_err = $ename_err = "";
$row = $row1 = ""; 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
     // Validate name
    $input_ename = trim($_POST["ename"]);
  //check if the field is empty
    if(empty($input_ename)){
        $ename_err = "Please enter a Experiment name.";
      //Validate if there are any special characters using regular expressions
    } elseif(!filter_var(trim($_POST["ename"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $ename_err = 'Please enter a valid Experiment name.';
      //If the name is proper assign it to variable
    } else{
        
        $ename = $input_ename;
    }
  
    // Check if there is any error in name before inserting in database
    if(empty($ename_err)){
        
        // Prepare an insert statement
      
      $sql = "INSERT INTO experiment (expname) VALUES (:ename)";
      // Ectract the value of taskid's that are checked.
      $checkbox = $_POST['tname'];
      echo sizeof($checkbox);
     
        if($stmt = $pdo->prepare($sql)){
          if((sizeof($checkbox)) >0){
         // Bind variables to the prepared statement as parameters
         $stmt->bindParam(':ename', $param_ename);
         // Set parameters
         $param_ename = $ename;
         // Attempt to execute the prepared statement
          if($stmt->execute()){
            
            //Select the expid for the recently inserted experiemnt name and load it into $row1
            $query = "SELECT expid FROM experiment WHERE expname = '". $ename ."'";
            $result = $pdo->query($query);
            $row1 = $result->fetch();
            } else{
                echo "Something went wrong. Please try again later.";
            }
          
         // Close statement
        unset($stmt);
      // Insert the taskid's that are associated with the experiment using loop
    for ($i=0; $i<sizeof($checkbox); $i++)
        {
          // Prepare an insert statement
          $query1="INSERT INTO taskexp (expid,taskid) VALUES ($row1[0],$checkbox[$i])";  
          if($stmt1 = $pdo->prepare($query1)){
            // Attempt to execute the prepared statement
            if($stmt1->execute()){
             
              
            } else{
                echo "Something went wrong. Please try again later.";
            }
             // Records created successfully. Redirect to page containing all the experiments
              header("location:Experiment.php");
        }
      else{echo "some error";}
       }
       }
          else {$error = "Select atleast one task";}
     }
   }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Area | MU Research Dashboard</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
  </head>
  <body>
    <!-- Navigation bar -->
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
           <?php  echo " <li><a href='edit_signup.php'>Welcome ". $_SESSION['login_user'];
           echo " </a></li>";?>
            <li><a href="login.php">Logout</a></li>
            
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> MU Reasearch Dashboard </h1>
          </div>
          <div class="col-md-2">
            <div class="dropdown create">
              <!-- Details of the dropdown menu -->
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
            <!-- Create Experiment -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Create Experiment</h3>
              </div>
              <div class="panel-body">
                 <br>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                  <div class="form-group <?php echo (!empty($ename_err)) ? 'has-error' : ''; ?>">
                    <label>Experiment Name</label>
                    <input type="text" name="ename" class="form-control" value="<?php echo $ename; ?>">
                    <span class="help-block"><?php echo $ename_err;?></span>
                  </div>
     
                  <div class="form-group">
                    <label>Tasks with their ID and Name</label>
                    <br>
                    <?php  
                    // Include config file
                    require_once 'config.php';
                    //select and display all the tasks that are available 
                    $sql = "SELECT taskid,tname FROM task";
                    if($tname = $pdo->query($sql)){
                      //Display all the task id's and its name in the form of checkbox
                      while ($row = $tname->fetch())
                        {                            
                            echo "<tr><td>";
                            echo "<input type='checkbox' name='tname[]' value = ";
                            echo $row['taskid'];
                            echo " />";
                            echo $row['taskid'];
                            echo "          ";
                            echo $row['tname'];
                            echo "</td></tr><br/>";
                        }
                    }
                     ?>
                    <span class="help-block"><?php echo $error;?></span>
                  </div>
                  <div class="form-group">
                  </div>
              
                  <input type="submit" class="btn btn-danger" value="Submit">
                  <a href="Experiment.php" class="btn btn-default">Cancel</a>
                </form> 
             </div>
              </div>

          </div>
        </div>
      </div>
    </section>
   
      <p></p>
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
