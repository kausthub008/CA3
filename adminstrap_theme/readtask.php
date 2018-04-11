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
             <!-- Add Task -->

           <?php
        require_once 'config.php';
         $id = $_GET['taskid'];
        
        if(isset($id) && !empty($id)){
                
                  require_once 'config.php';
                  $abc = "SELECT taskid,tname,tinstruction,tlink FROM task WHERE taskid = $id";
      
        $pat = $pdo->query($abc);
        $row1 = $pat->fetch();
        } else{
    // Check existence of id parameter
    if(empty(trim($_GET["taskid"]))){
        
        exit();
    }
}
        
        ?>
      <form>
      <div class="modal-body">
        <div class="form-group">
          <label>Task ID</label>
          <input type="text" class="form-control" value="<?php echo $row1[taskid]; ?>" readonly></a>
        </div>
        <div class="form-group">
          <label>Task Name</label>
          <input type="text" class="form-control" value="<?php echo $row1[tname]; ?>" readonly>
        </div>
      
        <div class="form-group">
          <label>Task instruction</label>
          <input type="text" class="form-control" value="<?php echo $row1[tinstruction]; ?>" readonly>
        </div>
        <div class="form-group">
          <label>Task link</label>
          <input type="text" class="form-control" href = "<?php echo $row1[tlink]; ?>" value = "<?php echo $row1[tlink]; ?>"  readonly>
        </div>
      </div>
      <div class="modal-footer">
        <a type="button" href="Task.php" class="btn btn-primary" >Back</a>
      </div>
    </form>
  
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
