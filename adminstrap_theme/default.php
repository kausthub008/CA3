<?php
  
       session_start();
//If user is not logged out from the previous session it will automatically redirect to login page
                  if (!isset($_SESSION['login_user'])){
                    
          
                    header("location:login.php");
                  }
      
?>