<?php
session_start();
include ("include/dbcon.inc.php");
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
 <link rel="stylesheet" href="css/nav.css" type="text/css">
<link rel="stylesheet" href="css/reports.css" type="text/css">

<ul>
  <li><a href="login.php?logout='1'">Logout</a></li>
  <li><a href="request.php">Requests</a></li>
  <li><a href="reports.php">Reports</a></li>
  <li><a href="add.php">Add Users</a></li>
  <li><a href="edit.php">Edit Users</a></li>
  <li><a href="delete.html">Delete Users</a></li>

  
</ul>
</head>

<form>
  <div class="reportform">
 <br><body>
 
 <br><br><label for="reports"><b> Reports</b></label>
  <select>
  <option value="r1">events report</option>
  <option value="r2">food orders report </option>
  <option value="r3">decorations requests report </option>
  <option value="r4">technical support requests report </option>
  <option value="r5">auditorium income report</option>
  <option value="r6">food income report </option>
  <option value="r7">income from technical support </option>
  <option value="r8">income from decorations</option>
  </select>
  
  <label action="/action_page.php"><b>Date from</b></label>
    <input type="date" name="reservation date" required>
	
	<label action="/action_page.php"><b>Date To</b></label>
    <input type="date" name="reservation date" required>
      <button type="submit" class="requestbutton">Generate</button>
 <?php
 $sql_query = "SELECT a.fname,alname,s.uid,s.date,s.time,s.packs,s.purpose,s.total,f.descrp,f.price,t.descrp,t.price,d.descrp,d.plus,d.price 
from tb_reservation as s,tb_food as f,tb_technical as t,tb_deco as a,tb_customer as a WHERE s.fid=f.fid AND s.tid=t.tid AND s.did=d.did AND s.uid=a.email";
 $sql = $conn->prepare($sql_query);
 $sql->execute();
 $numRows = $sql->fetchAll();

 if(count($numRows)>0) {
     foreach ($numRows as $row) {
         $fname = $row[0];
         $lname = $row[1];
         $email = $row[2];
         $date = $row[3];
         $time = $row[4];
         $packs = $row[5];
         $purpose = $row[6];
         $total = $row[7];
         $fdesc = $row[8];
         $fprice = $row[9];
         $tdesc = $row[10];
         $tprice = $row[11];
         $ddesc = $row[12];
         $dplus = $row[13];
         $dprice = $row[14];
     }
 }
 ?>
 <iframe src="http://docs.google.com/gview?url=http://example.com/mypdf.pdf&embedded=true" style="width:718px; height:700px;" frameborder="0"></iframe>
	</div>
</form>