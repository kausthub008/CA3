<?php
//call the default.php page which takes care of unexpected exit from browser and brings back user to same state once he logs in
        include("default.php");  
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
                <h3 class="panel-title">Orders</h3>
              </div>
              <div class="panel-body">
                 <br>
                <table class="table table-striped table-hover">
                       <?php
                     // Include config file
                    require_once 'config.php';
                    $asd = $_GET["expid"];
                    // Attempt select query execution
                   
                  $sql = "SELECT a.orderid FROM orders a, orderexp b WHERE a.orderid = b.orderid AND b.expid ='". $asd ."'";
                 
                  // Check if the query was executed
                    if($result = $pdo->query($sql)){
                      //check if there were an records in the table
                        if($result->rowCount() > 0){
                           
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>orderid</th>";
                                        echo "<th>Associated Tasks</th>";
                                        echo "<th>Associated Users</th>";
                                        echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                          //Fetch it untill the records are present in the table
                                while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['orderid'] . "</td>";
                                        
                                         $id = $row['orderid'];
                                        $sql1 ="SELECT b.taskid as TaskID FROM orderexp a,ordertask b where a.orderid = '". $id ."' and a.orderid=b.orderid";
                                    //display associated tasks
                                        if($result1 = $pdo->query($sql1)){
                                        $ab = "";
                                           while($row1 = $result1->fetch()){
                                            
                                                 $ab = $ab . $row1['TaskID'] ."  ";
                                                 
                                           }
                                          echo "<td>" . $ab . "</td>";
                                        }
                                        $sql2 ="SELECT b.userid as userid FROM orderexp a,orderuser b where a.orderid = '". $id ."' and a.orderid=b.orderid";
                                  //display associated Users
                                        if($result2 = $pdo->query($sql2)){
                                        $ab1 = "";
                                           while($row2 = $result2->fetch()){
                                            
                                                 $ab1 = $ab1 . $row2['userid'] ."  ";
                                                
                                           }
                                          echo "<td>" . $ab1 . "</td>";
                                        }
                                    
                                        echo "<td>";
                                  //display read, update and elete records
                                            echo "<a class='btn btn-default' href='edit_order.php?orderid=". $row['orderid'] ."&expid=". $asd ."'>edit</a>";
                                            echo "<a class='btn btn-danger' href='delete_order.php?orderid=". $row['orderid'] ."&expid=". $asd ."'>delete</a>";
                                            echo "<a class='btn btn-default' href='readexp.php?expid=". $asd ."'>Back</a>";                                            
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
