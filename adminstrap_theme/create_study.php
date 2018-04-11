<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$studyid = $expid = $studyname = "";
$studyid_err = $expid_err = $studyname_err = "";
$row = $row1 = "";
$error = "";
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
     
     // Validate name
    $input_sname = trim($_POST["studyname"]);
  //check if the field is empty
    if(empty($input_sname)){
        $studyname_err = "Please enter a study name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["studyname"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $studyname_err = 'Please enter a valid study name.';
    } else{
        echo "ff";
        $studyname = $input_sname;
    }
 
  //Extract the values that are checked in
  $checkbox = $_POST['expname'];
  //Make sure one experiment is not part of multiple studies 
   for ($k=0; $k<sizeof($checkbox); $k++){
     
      $abc = "SELECT * FROM studyexp where expid = $checkbox[$k]";
    
   $del = $pdo->prepare($abc);
    $del->execute();
    $count = $del->rowCount();
     
     if($count > 0)
      {
        $error = "You cannot add this experiment since it is already used in different study";
      }
   }
 // check for any error in the experiment choosed
if(empty($error)){
    // Check input errors before inserting in database
    if(empty($studyname_err)){
        
        // Prepare an insert statement
      
         $sql = "INSERT INTO study (studyname) VALUES ('$studyname')";
         print "query1 = $sql"; 
        if($stmt = $pdo->prepare($sql)){
                      // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':studyname', $param_sname);
                     
            // Set parameters
            $param_sname = $studyname;
           
            // Attempt to execute the prepared statement
            if($stmt->execute()){
              //extract the study id that was created
              $query = "SELECT studyid FROM study WHERE studyname = '". $studyname ."'";
              $result = $pdo->query($query);
              $row1 = $result->fetch();
              
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }

   //insert the associated experiments into the table
    for ($i=0; $i<sizeof($checkbox); $i++)
        {
             
            $query1="INSERT INTO studyexp (studyid,expid) VALUES ($row1[0],$checkbox[$i])";  
           //prepare the query
            if($stmt1 = $pdo->prepare($query1)){
          
            // Attempt to execute the prepared statement
            if($stmt1->execute()){
             
                // Records created successfully. Redirect to study page
                header("location: Study.php");
             
              
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
      else{echo "some error";}
           
        }
}
    echo "Complete";

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
            <li><a href="#">Welcome, Prajeth</a></li>
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

            <div class="well">
              <h4></h4>
              <div class="progress">
                  <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">
                  
              </div>
            </div>
            <h4> </h4>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="0" style="width: 0%;">
                  
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
                  <div class="form-group <?php echo (!empty($studyname_err)) ? 'has-error' : ''; ?>">
                    <label>study Name</label>
                    <input type="text" name="studyname" class="form-control" value="<?php echo $studyname; ?>">
                    <span class="help-block"><?php echo $studyname_err;?></span>
                  </div>
     
                  <div class="form-group" <?php echo (!empty($error)) ? 'has-error' : ''; ?>>
                    <label>Associated experiments</label>
                    <br>
                    <?php  
                    require_once 'config.php';
                    $sql = "SELECT expid,expname FROM experiment";
                   // print "query1 = $sql";
                    if($ename = $pdo->query($sql)){
                      //check if there were an records in the table
                       echo "dd";
                        while ($row = $ename->fetch())
                        {                            
                            echo "<tr><td>";
                            echo "<input type='checkbox' name='expname[]' value = ";
                            echo $row['expid'];
                            echo " />";
                            //echo " />";
                            echo $row['expname'];
                            echo "</td></tr><br/>";
                        }
                    }
                     ?>
                    <span class="help-block"><?php echo $error;?></span>
                  </div>
                    
                  <input type="submit" class="btn btn-default" value="Submit">
                  <a href="Study.php" class="btn btn-default">Cancel</a>
                </form> 
             </div>
              </div>

          </div>
        </div>
      </div>
    </section>

    <footer id="footer">
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
