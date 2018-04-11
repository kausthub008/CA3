<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$name = $gender = $age = $email = "";
$name_err = $gender_err = $age_err = $email_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["userid"]) && !empty($_POST["userid"])){
    // Get hidden input value
    $userid = $_POST["userid"];
     // Validate name
    $input_name = trim($_POST["name"]);
  //check if the field is empty
  
    if(empty($input_name)){
        $name_err = "Please enter a name.";
      //Validate if there are any special characters
    } elseif(!filter_var(trim($_POST["name"]), FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z'-.\s ]+$/")))){
        $name_err = 'Please enter a valid name.';
    } else{
        $name = $input_name;
    }
    
    // Validate address address
    $input_gender = trim($_POST["gender"]);
  //check if the field is empty
    if(empty($input_gender)){
        $gender_err = 'Please enter an gender.';     
    } 
    else{
        $gender = $input_gender;
    }
    
    // Validate salary
    $input_age = trim($_POST["age"]);
  //check if the field is empty
    if(empty($input_age)){
        $age_err = "Please enter the age.";
      //check if the entered value is a positive digit
    } elseif(!ctype_digit($input_age)){
        $age_err = 'Please enter a positive integer value.';
    } 
    elseif($input_age >'120'){
     
    $age_err = 'please enter valid age';
  }else{
        $age = $input_age;
    }
    
   //Validate Taxpaid
   $input_email = trim($_POST["email"]);
  //check if the field is empty
    if(empty($input_email)){
        $email_err = "Please enter email."; 
      //check if the entered value is a positive digit
    }else{
        $email = $input_email;
    }
   echo $name_err;
  echo $age_err;
  echo $gender_err;
  echo $email_err;
      // Check input errors before inserting in database
    if(empty($name_err) && empty($age_err) && empty($gender_err) && empty($email_err)){
        // Prepare an insert statement
      
        $sql = "UPDATE users SET name=:name, gender=:gender, age=:age, email=:email WHERE userid=:userid";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':name', $param_name);
            $stmt->bindParam(':gender', $param_gender);
            $stmt->bindParam(':age', $param_age);
            $stmt->bindParam(':email', $param_email);
            $stmt->bindParam(':userid', $param_userid);
            
            // Set parameters
            $param_name = $name;
            $param_gender = $gender;
            $param_age = $age;
            $param_email = $email;
            $param_userid = $userid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: users.php");
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
    if(isset($_GET["userid"]) && !empty(trim($_GET["userid"]))){
        // Get URL parameter
        $userid =  trim($_GET["userid"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE userid = :userid";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(':userid', $param_userid);
            
            // Set parameters
            $param_userid = $userid;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $name = $row["name"];
                    $gender = $row["gender"];
                    $age = $row["age"];
                    $email = $row["email"];
                  
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
            <li><a href="#">Welcome</a></li>
            <li><a href="login.html">Logout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-10">
            <h1><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> MU Research Dashboard <small>Manage Your Site</small></h1>
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
                <h3 class="panel-title">Edit the User</h3>
              </div>
              <div class="panel-body">
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                  <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control"  placeholder="name" value="<?php echo $name; ?>">
                    <span class="help-block"><?php echo $name_err;?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($gender_err)) ? 'has-error' : ''; ?>">
                    <label>Gender</label>
                    <select class="form-control" name="gender" value="<?php echo $gender; ?>">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="NA">NA</option>
                    </select>
                  </div>
                   <div class="form-group <?php echo (!empty($age_err)) ? 'has-error' : ''; ?>">
                    <label>Age</label>
                    <input type="text" name="age" class="form-control" placeholder="Add Some Tags..." value="<?php echo $age; ?>">
                     <span class="help-block"><?php echo $age_err;?></span>
                  </div>
                  <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                    <label>Email</label>
                    <input type="text" name="email"class="form-control" placeholder="Add Meta Description..." value="<?php echo $email; ?>">
                    <span class="help-block"><?php echo $email_err;?></span>
                  </div>
                  <input type="hidden" name="userid" value="<?php echo $userid; ?>"/>
                  <input type="submit" class="btn btn-danger" value="Submit">
                  <a href="users.php" class="btn btn-default">Cancel</a>
                </form> 
              </div>
              </div>
          </div>
        </div>
      </div>  
    </section>

   <!-- <footer id="footer">
      <p>Copyright AdminStrap, &copy; 2017</p>
    </footer> -->
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
