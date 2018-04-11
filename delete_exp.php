<?php
//call the default.php page which takes care of unexpected exit from browser and brings back user to same state once he logs in
        include("default.php");  
 ?>
<?php
// Process delete operation after confirmation
if(isset($_POST["expid"]) && !empty($_POST["expid"])){
    // Include config file
    require_once 'config.php';
  $id = $_POST["expid"];
    // Prepare a delete sstatement
    $sql = "DELETE FROM experiment WHERE expid = $id";
    $sqla = "DELETE FROM taskexp where expid = $id";
    $sqlb = "DELETE from orderuser where orderid in (select orderid from orderexp where expid = $id)";
    $sqlc = "DELETE from ordertask where orderid in (select orderid from orderexp where expid = $id)";
    $sqld = "DELETE FROM orderexp where expid = $id";
    $sqle = "DELETE FROM studyexp where expid = $id";
    
    //prepare the delete statements    
    if($stmt = $pdo->prepare($sql)){
      if($stmta = $pdo->prepare($sqla)){
        if($stmtb = $pdo->prepare($sqlb)){
          if($stmtc = $pdo->prepare($sqlc)){
            if($stmtd = $pdo->prepare($sqld)){
              if($stmte = $pdo->prepare($sqle)){
      
       
        // Attempt to execute the prepared statement
        if($stmt->execute()){
          if($stmta->execute()){
            if($stmtb->execute()){
              if($stmtc->execute()){
                if($stmtd->execute()){
                  if($stmte->execute()){
                
             
               // Records deleted successfully. Redirect to landing page
               header("location: Experiment.php");
               //this command is used to exit from the loop 
               exit();
                }
            }
          }
             } 
           }
         }else{
            echo "Oops! Something went wrong. Please try again later.";
        }
            }
        }
      }
       }
      }
  
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter
    if(empty(trim($_GET["expid"]))){
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
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span>MU Research Dashboard<small></small></h1>
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
              <a href="index.html" class="list-group-item active main-color-bg">
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
                <h3 class="panel-title">Delete Experiment</h3>
              </div>
              <div class="panel-body">
                <div class="row">
                      <div class="col-md-12">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in" style = "background: #ffffff;">
                            <input type="hidden" name="expid" value="<?php echo trim($_GET["expid"]); ?>"/>
                            
                            <p style = "color: #000000";>Are you sure you want to delete this experiment?</p><br>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                              <!-- Once No or Yes is pressed the functionaity moves to index page -->
                                <a href="Experiment.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                      </div>
                </div>
                <br>
                <table class="table table-striped table-hover">
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
