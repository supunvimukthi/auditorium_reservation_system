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
    <script type="text/javascript" src="js/jspdf.min.js"></script>
    <script type="text/javascript" src="js/jspdf.plugin.autotable.js"></script>
    <script src="js/jquery.min.js"></script>

<ul>
  <li><a href="login.php?logout='1'">Logout</a></li>
  <li><a href="request.php">Requests</a></li>
  <li><a href="reports.php">Reports</a></li>
  <li><a href="add.php">Add Users</a></li>
  <li><a href="edit.php">Edit Users</a></li>
  <li><a href="delete.html">Delete Users</a></li>

  
</ul>
</head>
<body>
<form>
  <div class="reportform">
 <br><body>
 
 <br><br><label for="reports"><b> Reports</b></label>
  <select id="report">
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
 <script>
     if(document.getElementById('report')).value=="r1"){

     }
     if(document.getElementById('report')).value=="r2"){

     }
     if(document.getElementById('report')).value=="r3"){

     }
     if(document.getElementById('report')).value=="r4"){

     }
     if(document.getElementById('report')).value=="r5"){

     }
     if(document.getElementById('report')).value=="r6"){

     }
     if(document.getElementById('report')).value=="r7"){

     }
     if(document.getElementById('report')).value=="r8"){

     }



         </tr>
 </script>
 <div class="requests">
     <h2>Requests</h2>

     <table id="table"  style="visibility:hidden;width:50%">
         <tr id="head">
             <th>Customer</th>
             <th>Date</th>
             <th>Time</th>
             <th>Packs</th>
             <th>Purpose</th>
             <th>Total</th>
             <th>Approve</th>

             <table id="table"  style="width:50%">
                 <tr id="head">
                     <th>Customer</th>
                     <th>Date</th>
                     <th>Time</th>
                     <th>Packs</th>
                     <th>Purpose</th>
                     <th>Total</th>
                     <th>Approve</th>

                     <table id="table"  style="width:50%">
                         <tr id="head">
                             <th>Customer</th>
                             <th>Date</th>
                             <th>Time</th>
                             <th>Packs</th>
                             <th>Purpose</th>
                             <th>Total</th>
                             <th>Approve</th>


 <?php
 $sql_query = "SELECT a.fname,a.lname,s.uid,s.date,s.time,s.packs,s.purpose,s.total,f.descrp,f.price,t.descrp,t.price,d.descrp,d.plus,d.price 
from tb_reservation as s,tb_food as f,tb_technical as t,tb_deco as d,tb_customer as a WHERE s.fid=f.fid AND s.tid=t.tid AND s.did=d.did AND s.uid=a.email";
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
         echo "<script>

     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }
     if(document.getElementById('report').value=='r5'){
    
     }</script>";
     }
 }
 ?>



	</div>
</form>
<script type="text/javascript">
    function PdfFromHTML() {
        var pdf = new jsPDF('l', 'pt', 'a4');
        pdf.setFontSize(6);
        var res = pdf.autoTableHtmlToJson(document.getElementById("table"), false);
        pdf.autoTable(res.columns, res.data, {
            startY: 60,
            tableWidth: 'auto',
            columnWidth: 'auto',
            styles: {
                overflow: 'linebreak'
            }
        });
        pdf.save("Data-sheet.pdf");


    }
</script>
</body>
</html>