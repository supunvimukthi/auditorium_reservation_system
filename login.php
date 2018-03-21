<?php
session_start();

include ("include/dbcon.inc.php");
if (isset($_POST['btn_log']))
{
    $uid = $_POST['uname'];
    $psw = $_POST['psw'];
    $_SESSION['uname'] = $uid;
    $sql_query = "SELECT * FROM db_users where username='$uid' and password='$psw'";
    $sql = $conn->prepare($sql_query);
    $sql->execute();
    $numRows = $sql->fetchAll();
    if(count($numRows)>0)
    {
        foreach($numRows as $row)
        {
            $type=$row['user_type'];
            $_SESSION['type']=$type;
            if ($type=="customer") {
                header('location:reservation.php');
                //exit;
            }
            else{
                header('location:request.php');
                //exit;
            }
        }
    }
    else{
        echo "<script type='text/javascript'>alert('Invalid Username or Password ');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/nav.css" type="text/css">
<link rel="stylesheet" href="css/login.css" type="text/css">

 </head>
 
 <body>
 <ul>
     <li><a href="home.html">About Us</a></li>
     <li><a href="login.php">Login</a></li>
     <li><a href="terms.html">Terms & Privacy Policy</a></li>
     <li><a href="gallery.html">Gallery</a></li>
     <li><a href="contact.php">Contact</a></li>

 </ul>
 <form name="login" action="login.php" method="post">
  <div class="girlimg">
    <img src="img/girl.png" alt="girl" class="girl">
  </div>

  <div class="login">
    <label><b>User Name</b></label>
    <br><input type="text" placeholder="Enter Your Username" name="uname" value="" required>

    <br><label><b>Password</b></label>
    <br><input type="password" placeholder="Enter Your Password" name="psw" required>

      <br><button type="submit" name="btn_log">Login</button>
   <label>
      <input type="checkbox" checked="checked"> Remember me
    </label>
  </div>

  <br><br><div class="register">Not an existing user?<a href="signup.php">Sign up here</a>
  </div>
</form> 
</body>
</html>
