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

    <nav  class="navbar navbar-default">
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
                <span class="glyphicon glyphicon-cog" aria-hidden="true"></span> Dashboard
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
                <h3 class="panel-title">Studies</h3>
              </div>
              <div class="panel-body">
                 <br>
                <table class="table table-striped table-hover">
                       <?php
                     // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    //$sql = "SELECT taskid,tname,tinstruction,tlink FROM task";
                  $sql = "select studyid,studyname from study";
                  
                  // Check if the query was executed
                    if($result = $pdo->query($sql)){
                      //check if there were an records in the table
                        if($result->rowCount() > 0){
                           
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Studyid</th>";
                                        echo "<th>Studyname</th>";
                                        echo "<th>Expids's</th>";
                                        echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                          //Fetch it untill the records are present in the table
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['studyid'] . "</td>";
                                        echo "<td>" . $row['studyname'] . "</td>";
                                         $id = $row['studyid'];
                                        $sql1 ="SELECT b.expid as experimentid FROM studyexp a,experiment b where a.studyid = '". $id ."' and a.expid=b.expid";
                                        if($result1 = $pdo->query($sql1)){
                                        $ab = "";
                                          //fetch all the associated experiments
                                           while($row1 = $result1->fetch()){
                                                 //concatenating the experiment id's
                                                 $ab = $ab . $row1['experimentid'] ."  ";
                                                
                                           }
                                          echo "<td>" . $ab . "</td>";
                                        }
                                                                           
                                        echo "<td>";
                                  //display read, update and elete records
                                            echo "<a class='btn btn-default' href='edit_study.php?studyid=". $row['studyid'] ."'>edit</a>";
                                            echo "<a class='btn btn-danger' href='delete_study.php?studyid=". $row['studyid'] ."'>delete</a>";
                                            echo "<a class='btn btn-danger' href='studyexp.php?studyid=". $row['studyid'] ."'>details</a>";
                                            echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
                    }
                    
                    // Close connection
                    unset($pdo); 
             ?>
                 </table>
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
