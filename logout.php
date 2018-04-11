<?php
     session_start();
//if logout is pressed from any page it will redirect to the login page directly
if(session_destroy())
{
  header("Location:login.php");
}
?>