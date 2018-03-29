<?php

include ("include/dbcon.inc.php");
if (isset($_POST['submit']))
{
    $type = $_POST['type'];
    $fname = $_POST['txt_fname'];
    $lname = $_POST['txt_lname'];
    $email = $_POST['txt_email'];
    $address = $_POST['txt_address'];
    $pnum1 = $_POST['txt_pnum1'];
    $pnum2 = $_POST['txt_pnum2'];
    $pw = $_POST['pw'];
    $cpw = $_POST['cpw'];
    if (strlen($pnum1)>10 or strlen($pnum1)<10 or strlen($pnum2)>10 or strlen($pnum2)<10 or !is_numeric($pnum1) or  !is_numeric($pnum2) or strlen($pw)<6 ){
        if (strlen(($pw)<6)){
            echo "<script type='text/javascript'>alert('Password must contain more than 6 characters');</script>";

        }
        else {
            echo "<script type='text/javascript'>alert('Telephone number should be 10 digits and should only contain numbers');</script>";
        }
    }
    else {


        if ($cpw == $pw) {
            try {
                $sql_query = "SELECT username from db_users WHERE username='$email'";
                $sql = $conn->prepare($sql_query);
                $sql->execute();
                $numRows = $sql->fetchAll();

                if (!(count($numRows) > 0)) {
                    if ($type == 'decoration') {
                        $sql_query = "INSERT INTO tb_deco_employees(fname,lname,email,address,pnum1,pnum2)
            VALUES (:fname,:lname,:email,:address,:pnum1,:pnum2)";
                    } elseif ($type == 'food') {
                        $sql_query = "INSERT INTO tb_food_employees(fname,lname,email,address,pnum1,pnum2)
            VALUES (:fname,:lname,:email,:address,:pnum1,:pnum2)";
                    } elseif ($type == 'technical') {
                        $sql_query = "INSERT INTO tb_technical_employees(fname,lname,email,address,pnum1,pnum2)
            VALUES (:fname,:lname,:email,:address,:pnum1,:pnum2)";
                    } else {
                        $sql_query = "INSERT INTO tb_customer(fname,lname,email,address,pnum1,pnum2)
            VALUES (:fname,:lname,:email,:address,:pnum1,:pnum2)";
                    }
                    $sql = $conn->prepare($sql_query);

                    $sql->bindParam(':fname', $fname);
                    $sql->bindParam(':lname', $lname);
                    $sql->bindParam(':email', $email);
                    $sql->bindParam(':address', $address);
                    $sql->bindParam(':pnum1', $pnum1);
                    $sql->bindParam(':pnum2', $pnum2);


                    $sql->execute();
                    // echo "Insert......";
                    $sql_query = "INSERT INTO db_users(username,password,user_type)
            VALUES (:email,:pw,:ut)";
                    $sql = $conn->prepare($sql_query);

                    $sql->bindParam(':email', $email);
                    $sql->bindParam(':pw', $pw);
                    $sql->bindParam(':ut', $type);

                    $sql->execute();
                    echo "<script type='text/javascript'>alert('User was Successfully registered in the System');</script>";
                } else {
                    echo "<script type='text/javascript'>alert('User Already Exist');</script>";
                }
            } catch (PDOException $e) {
                echo "Error Found</br>" . $e->getMessage();
            }
        } else {
            echo "<script type='text/javascript'>alert('Two Passwords have to be the same ');</script>";
        }
    }






}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/nav.css" type="text/css">
<link rel="stylesheet" href="css/add.css" type="text/css">
<ul>
    <li><a href="login.php">Logout</a></li>
    <li><a href="request.php">Requests</a></li>
    <li><a href="reports.php">Reports</a></li>
    <li><a href="add.php">Add Users</a></li>
    <li><a href="edit.php">Edit Users</a></li>
    <li><a href="delete.html">Delete Users</a></li>
  </ul>
</head>
 <br><body>
 
 <form action="add.php" method="post">
  <div class="addingform">
    <h1>Sign Up</h1>
	
    <br> <label for="type "><b>User Type</b></label>
    <br><select name="type">
          <option value="decoration">decoration</option>
          <option value="food">food</option>
          <option value="technical">technical</option>
          <option value="customer">customer</option></select>

      <br> <label for="First Name "><b>First Name</b></label>
      <br><input type="text" placeholder="Enter your first name" name="txt_fname" id="txt_fname"   value="" required>

      <br><label for="Last Name"><b>Last Name</b></label>
      <br><input type="text" placeholder="Enter your last name" name="txt_lname" value="" required>

      <br><label for="email"><b> Email</b></label>
      <br><input type="email" placeholder="Enter your email" name="txt_email" value="" required>

      <br><label for="address"><b>Address</b></label>
      <br><input type="text" placeholder="Enter your address" name="txt_address" value="" required>

      <br><label for="Phonenumber1"><b>Phone number 1</b></label>
      <br><input type="text" placeholder="Enter your phone number" name="txt_pnum1" value="" required>

      <br><label for="Phone number 2"><b> Phone number 2</b></label>
      <br><input type="text" placeholder="Enter your phone number" name="txt_pnum2" value="" required>

      <br><label for="password"><b> Password</b></label>
      <br><input type="password" placeholder="Enter your password" name="pw" value="" required>

      <br><label for="password"><b>Confirm Password</b></label>
      <br><input type="password" placeholder="Reenter your password" name="cpw" value="" required>

      <br><label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>

    <div class="signup">
      <button type="submit" class="signupbutton" name="submit">Sign Up</button>
    </div>
  </div>
</form>
 
 </body>
</html>