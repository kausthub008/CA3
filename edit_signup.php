<?php
//call the default.php page which takes care of unexpected exit from browser and brings back user to same state once he logs in
        include("default.php");  
 ?>
<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $email = $ph = $error = "";
$username_err = $password_err = $email_err = $ph_err = "";
 
// Processing form data when form is submitted
if(isset($_SESSION['login_user']) && !empty($_SESSION['login_user'])){
     
    // Validate password
    $input_pass = trim($_POST["password"]);
    if(empty($input_pass)){
        $password_err = 'Please enter an password.';     
    } else{
        $password = $input_pass;
    }
  
	  // Validate email
     $input_email = $_POST["email"];
	    if(empty($input_email)){
				$email_err = "Please enter email";
			}elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
       
      $email_err = "Invalid email format"; 
      } else{
         
      $email = $input_email;
      }
    
	  //validate phone number
  $input_ph = trim($_POST["ph"]);
	if(empty($input_ph)){
				$ph_err = "Please enter phone number";
			}elseif(!is_numeric($input_ph)){
      
        $ph_err = 'Please enter phone number';     
    } else{
      
        $ph = $input_ph;
    }
      
    // Check if all the fields are error free  
    if(empty($password_err) && empty($email_err) && empty($ph_err) ){
        
        // Prepare an insert statement
        $sql = "UPDATE webusers set password=:password, email=:email, ph=:ph where username = '". $_SESSION['login_user'] ."'";
			 print "query = $sql";
 
        if($stmt = $pdo->prepare($sql)){
          
            // Bind variables to the prepared statement as parameters
           
            $stmt->bindParam(':password', $param_password);
            $stmt->bindParam(':email', $param_email);
            $stmt->bindParam(':ph', $param_ph);
            
            
            // Set parameters
            $param_username = $username;
            $param_password = $password;
            $param_email = $email;
            $param_ph = $ph;
           
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
             
                // Records created successfully. Redirect to landing page
                header("location: login.php");
                exit();
            } else{
                echo "Something went wrong. Please try again ";
            }
        }
         
        // Close statement
        unset($stmt);
    }
	
    
    // Close connection
    unset($pdo);
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
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
            <h1 class="text-center"> MU Research Dashboard <small>Edit Profile </small></h1>
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
                    <input type="text" name = "username" class="form-control" value="<?php echo $_SESSION['login_user'];?>" readonly></input>
                    <span class="help-block"><?php echo $username_err;?></span>
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name = "password" class="form-control" placeholder="Enter password">
                    <span class="help-block"><?php echo $password_err;?></span>
                  </div>
                  <div class="form-group">
                    <label>Email Address</label>
                    <input type="text" name = "email" class="form-control" placeholder="Enter Email">
                    <span class="help-block"><?php echo $email_err;?></span>
                  </div>
                  <div class="form-group">
                    <label>Phone No</label>
                    <input type="text" name = "ph" class="form-control" placeholder="phone number">
                    <span class="help-block"><?php echo $ph_err;?></span>
                  </div>
                  <button type="submit" class="btn btn-default btn-block">Register</button>
                  <a href="login.php" class="btn btn-default btn-block">cancel</a>
							    
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
