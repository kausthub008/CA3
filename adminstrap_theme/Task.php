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

          </div>
          <div class="col-md-9">
            <!-- Website Overview -->
            <div class="panel panel-default">
              <div class="panel-heading main-color-bg">
                <h3 class="panel-title">Available Tasks</h3>
              </div>
              <div class="panel-body">
                 <br>
               <!-- <div class="container">-->
                <!-- <table class="table table-bordered"> -->
                 <table class="table table-striped table-hover">
                       <?php
                     // Include config file
                    require_once 'config.php';
                    
                    // Attempt select query execution
                    $sql = "SELECT taskid,tname,tinstruction,tlink FROM task";
                  // Check if the query was executed
                    if($result = $pdo->query($sql)){
                      //check if there were an records in the table
                        if($result->rowCount() > 0){
                           // echo "<table class='table table-striped table-hover'>";
                          //echo "<table border='1'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Taskid</th>";
                                        echo "<th>Taskname</th>";
                                        echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                          //Fetch it untill the records are present in the table
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['taskid'] . "</td>";
                                        echo "<td>" . $row['tname'] . "</td>";
                                        echo "<td>";
                                  //display read, update and elete records
                                            echo "<a class='btn btn-default' href='edit_task.php?taskid=". $row['taskid'] ."'>Edit</a>";
                                            echo "<a class='btn btn-danger' href='delete_task.php?taskid=". $row['taskid'] ."'>Delete</a>";
                                            echo "<a class='btn btn-default' href='readtask.php?taskid=". $row['taskid'] ."'>Details</a>";
                                            //echo "<button class='btn btn-primary' name='abc' data-target='#addtask' data-toggle='modal' value = ". $row['taskid'] .">Visualizar</button>";            
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

    <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer>
     <!-- Modals -->

     <!-- Add Task -->
<!--    <div class="modal fade" id="addtask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Task</h4>
      </div>
        <?php
        /*require_once 'config.php';
        $id = trim($_POST["abc"]);
        echo "id = $id";
        $abc = "SELECT taskid,tname,tinstruction,tlink FROM task WHERE taskid = $id";
        print "query1 = $abc";
        $pat = $pdo->query($abc);
        $row1 = $pat->fetch();*/
        
        ?>
      <div class="modal-body">
        <div class="form-group">
          <label>Task ID</label>
          <input type="text" name="expname" class="form-control" placeholder="Enter Task ID" value="<?php /*echo $row1[taskid];*/ ?>">
        </div>
        <div class="form-group">
          <label>Task Name</label>
          <input type="text" class="form-control" placeholder="Enter Task Name"></textarea>
        </div>
      
        <div class="form-group">
          <label>Task instruction</label>
          <input type="text" class="form-control" placeholder="Add Task link...">
        </div>
        <div class="form-group">
          <label>Task link</label>
          <textarea name="editor1" class="form-control"placeholder="Enter Task Description"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
    </form>
    </div>
  </div>
</div> -->

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
