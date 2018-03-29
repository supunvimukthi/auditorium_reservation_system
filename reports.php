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

<form method="post" action="reports.php">
    <div class="reportform">
        <br><body>

        <br><br><label for="reports"><b> Reports</b></label>
        <select name="report" id="report">
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
        <input type="date" name="sDate" required>

        <label action="/action_page.php"><b>Date To</b></label>
        <input type="date" name="eDate" required>
        <button type="submit" id="generate" name="generate" class="requestbutton">Generate</button>
        <input type="button"  id="pdf" onclick="PdfFromHTML()"  value="Print PDF" ></input>
        <div class="requests">
            <h2>Reports</h2>

            <table id="table"  style="width:50%">
                <tr id="head"></tr>




            </table>



        </div>
</form>

<?php
if(isset($_POST['generate'])) {
    $report=$_POST['report'];
    echo "<script>
        if('$report'==\"r1\"){
            document.getElementById(\"table\").deleteTHead();
            var header = document.getElementById('table').createTHead();
           // document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Customer';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Time';
            row.insertCell().innerHTML='Packs';
            row.insertCell().innerHTML='Purpose';
            row.insertCell().innerHTML='Food';
            row.insertCell().innerHTML='Deco';
            row.insertCell().innerHTML='Technical';
            row.insertCell().innerHTML='Total';
            


        }
        if('$report'==\"r2\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Customer';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Time';
            row.insertCell().innerHTML='Packs';
            row.insertCell().innerHTML='Purpose';
            row.insertCell().innerHTML='Food';
            row.insertCell().innerHTML='Price';
            
        }
        if('$report'==\"r3\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Customer';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Time';
            row.insertCell().innerHTML='Packs';
            row.insertCell().innerHTML='Purpose';
            row.insertCell().innerHTML='Deco';
            row.insertCell().innerHTML='Price';
          
        }
        if('$report'==\"r4\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Customer';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Time';
            row.insertCell().innerHTML='Packs';
            row.insertCell().innerHTML='Purpose';
            row.insertCell().innerHTML='Technical';
            row.insertCell().innerHTML='Price';
           
        }
        if('$report'==\"r5\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Event ID';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Food';
            row.insertCell().innerHTML='Deco';
            row.insertCell().innerHTML='Technical';
            row.insertCell().innerHTML='Total';
          
        }
        if('$report'==\"r6\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Event ID';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Food';
            row.insertCell().innerHTML='packs';
            row.insertCell().innerHTML='total';
            
           

        }
        if('$report'==\"r7\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Event ID';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Technical';
            
        }
        if('$report'==\"r8\"){
            document.getElementById('table').deleteTHead();
            var header = document.getElementById('table').createTHead();
            //document.getElementById('head').appendChild(header)
            var row=header.insertRow(0);
            row.insertCell().innerHTML='Event ID';
            row.insertCell().innerHTML='Date';
            row.insertCell().innerHTML='Deco';
         
            
            
        }
   
</script>";
    $sDate=$_POST['sDate'];
    $eDate=$_POST['eDate'];
    $sql_query = "SELECT a.fname,a.lname,s.uid,s.date,s.time,s.packs,s.purpose,s.total,f.descrp,f.price,t.descrp,t.price,d.descrp,d.plus,d.price,s.no 
from tb_reservation as s,tb_food as f,tb_technical as t,tb_deco as d,tb_customer as a WHERE s.fid=f.fid AND s.tid=t.tid AND s.did=d.did AND s.uid=a.email AND s.date BETWEEN '$sDate' and '$eDate' ORDER BY s.date";
    $sql = $conn->prepare($sql_query);
    $sql->execute();
    $numRows = $sql->fetchAll();

    if (count($numRows) > 0) {
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
            $no = $row[15];
            $ftotal=(int)$packs*(int)$fprice;
            echo "<script>
         if('$report'=='r1'){
            var row=document.getElementById('table').insertRow();
            row.insertCell().innerHTML='$fname $lname';
            row.insertCell().innerHTML='$date';
            row.insertCell().innerHTML='$time';
            row.insertCell().innerHTML='$packs';
            row.insertCell().innerHTML='$purpose';
            row.insertCell().innerHTML='$fdesc';
            row.insertCell().innerHTML=' $ddesc';
            row.insertCell().innerHTML='$tdesc';
            row.insertCell().innerHTML=' $total';
            
            
         }
         if('$report'=='r2'){
             var row=document.getElementById('table').insertRow();
              row.insertCell().innerHTML='$fname $lname';
              row.insertCell().innerHTML='$date';
              row.insertCell().innerHTML='$time';
              row.insertCell().innerHTML='$packs';
              row.insertCell().innerHTML='$purpose';
              row.insertCell().innerHTML='$fdesc';
              row.insertCell().innerHTML='$fprice';
        
         }
         if('$report'=='r3'){
             var row=document.getElementById('table').insertRow();
             row.insertCell().innerHTML='$fname $lname';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$time';
        row.insertCell().innerHTML='$packs';
        row.insertCell().innerHTML='$purpose';
        row.insertCell().innerHTML='$ddesc';
        row.insertCell().innerHTML='$dprice';
         }
         if('$report'=='r4'){
             var row=document.getElementById('table').insertRow();
             row.insertCell().innerHTML='$fname $lname';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$time';
        row.insertCell().innerHTML='$packs';
        row.insertCell().innerHTML='$purpose';
        row.insertCell().innerHTML='$tdesc';
        row.insertCell().innerHTML='$tprice';
         }
         if('$report'=='r5'){
             var row=document.getElementById('table').insertRow();
        row.insertCell().innerHTML='$no';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$fprice';
        row.insertCell().innerHTML='$dprice';
        row.insertCell().innerHTML='$tprice';
        row.insertCell().innerHTML='$total';
         }
         if('$report'=='r6'){
             var row=document.getElementById('table').insertRow();
        row.insertCell().innerHTML='$no';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$fprice';
        row.insertCell().innerHTML='$packs';
        row.insertCell().innerHTML='$ftotal';
        
        
         }
         if('$report'=='r7'){
             var row=document.getElementById('table').insertRow();
        row.insertCell().innerHTML='$no';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$tprice';
         }
         if('$report'=='r8'){
             var row=document.getElementById('table').insertRow();
        row.insertCell().innerHTML='$no';
        row.insertCell().innerHTML='$date';
        row.insertCell().innerHTML='$dprice';
         }
    </script>";
        }
    }
}

?>

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