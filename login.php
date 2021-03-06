<?php
// Include config file
require_once 'config.php';
session_start(); 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
      // username and password sent from form 
      $username = trim($_POST["username"]);
      $password = trim($_POST["password"]);
   
		
      $sql = "SELECT username,password FROM webusers WHERE username = '$username' and password = '$password'";
      // If result matched $username and $password, table row must be 1 row
		// Check if the query was executed
      if($result = $pdo->query($sql)){
				 //check if there were an records in the table
          if($result->rowCount() > 0){
          
         /*session_register("username");*/
         $_SESSION['login_user'] = $username;
         //once login is validated the control goes to the dashboard home
         header("location: index.php");
      }else{
					$error = "Your Login Name or Password is invalid";
            }
			} else{
                    $error = "Your Login Name or Password is invalid";
              }
	}
unset($pdo);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="http://cdn.ckeditor.com/4.6.1/standard/ckeditor.js"></script>
  </head>
  <body>
<style>
        label {
            color: white;
        }
        
        body {
            background: url(https://www.sevenforums.com/attachments/general-discussion/250721d1486599828t-any-ideas-how-my-login-background-screen-changed-its-own-backgrounddefault.jpg);
            background-size: cover;
            width: 100vw;
        }
		</style>
    <header id="header">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h1 class="text-center"> MU Research Dashboard <small>Login</small></h1>
          </div>
        </div>
      </div>
    </header>

    <section id="main">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                  <div class="form-group">
                    <label>Username</label>
                    <input type="text" name = "username" class="form-control" placeholder="Enter username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name = "password" class="form-control" placeholder="Enter password">
                    
                  </div>
                  <span class="help-block"><?php echo $error;?></span>
                  <button type="submit" class="btn btn-default btn-block">Login</button>
                  <a href="login.php" class="btn btn-default btn-block">cancel</a> 
							    <a href="signup.php" class="btn btn-default btn-block">Register</a>
              </form>
          </div>
        </div>
      </div>
    </section>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
