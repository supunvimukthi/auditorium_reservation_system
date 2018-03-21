<?php
session_start();
echo "<script type='text/javascript'>alert(\"Logged in as ".$_SESSION['uname']."\");</script>";
$uid = $_SESSION['uname'];
include ("include/dbcon.inc.php");
if (!isset($_SESSION['uname'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

if (isset($_POST['btn_rqst']))
{
    $no;
    $uid;
    $date = $_POST['date'];
    $time = $_POST['txt_time'];
    $packs = $_POST['txt_packs'];
    $purpose = $_POST['txt_purpose'];
    $fid = $_POST['txt_fid'];
    $did = $_POST['txt_did'];
    $tid = $_POST['txt_tid'];
    $total = $_POST['txt_total'];
    $app=0;


        try
        {
            $sql_query = "INSERT INTO tb_reservation(no,uid,date,time,packs,purpose,fid,did,tid,total,approved) 
		    VALUES (:no,:uid,:date,:time,:packs,:purpose,:fid,:did,:tid,:total,:app)";
            $sql = $conn->prepare($sql_query);

            $sql->bindParam(':no',$no);
            $sql->bindParam(':uid',$uid);
            $sql->bindParam(':date',$date);
            $sql->bindParam(':time',$time);
            $sql->bindParam(':packs',$packs);
            $sql->bindParam(':purpose',$purpose);
            $sql->bindParam(':fid',$fid);
            $sql->bindParam(':did',$did);
            $sql->bindParam(':tid',$tid);
            $sql->bindParam(':total',$total);
            $sql->bindParam(':app',$app);


            $sql->execute();
            echo "<script type='text/javascript'>alert('Your reservation has been made !');</script>";
        }
        catch (PDOException $e)
        {
            echo "Error Found</br>".$e->getMessage();
        }



}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/reservation.css" type="text/css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

    <script>
        var eventDates = {};
        <?php
        $sql_query = "SELECT date FROM tb_reservation where approved=1 order by date";
        $sql = $conn->prepare($sql_query);
        $sql->execute();

        $numRows = $sql->fetchAll();
        if(count($numRows)>0)
        {
            foreach($numRows as $row)
            {
                $date = $row['date'];

                echo "eventDates[ new Date( '$date 00:00:00' )] = new Date( '$date 00:00:00' );";
            }
        }
        ?>
        $(document).ready(function() {
            $("#datepicker").datepicker({
                dateFormat:"yy-mm-dd",
                beforeShowDay: function( date ) {
                    var highlight = eventDates[date];
                    if( highlight ) {
                        return [false, 'event', "Reserved"];
                    } else {
                        return [true, '', ''];
                    }
                }
            });

        });

    </script>

<ul>

  <li><a href="login.php?logout='1'">Logout</a></li>
  <li><a href="reservation.php">Reservation</a></li>

  
</ul>

 </head>
 <br><body>
 
 <form  action="reservation.php" name="request" method="post">
  <div class="reservationform">
    

   <br> <label><b>Date</b></label>
      <input name="date" id="datepicker" placeholder="YYYY-MM-DD" value="" required>

	
      <br><br><label><b>Time</b></label>
      <select  onchange="loadPrice()" name="txt_time" id="txt-time">
  <option value="morning">9.00 am - 02.00 pm</option>
  <option value="evening">03.00 pm - 12.00 am</option>
  <option value="day">9.00 am - 10.00 pm</option>
</select>

    <label <b>Price</b></label>
    <input id="audiprice" type="price" name="price for auditorium" required>

<br><br><label for="numberofpacks"><b>Number of packs</b></label>
	<br><select id="packs" name="txt_packs">
  <option value="150">150</option>
  <option value="200">200</option>
  <option value="250">250</option>
  <option value="300">300</option>
  <option value="350">350</option>
  <option value="450">450</option>
  <option value="550">550</option>
  <option value="600">600</option>
  
</select>
	
	<br><label for="address"><b>Purpose</b></label>
    <br><input type="text" placeholder="Enter your purpose" name="txt_purpose" required>

    <br><br><label for="foodid"><b> Food Id</b></label>
      <select id="food" onchange="loadData('food','foodtable','price')" name="txt_fid">
          <?php
          $sql_query = "SELECT fid FROM tb_food order by fid";
          $sql = $conn->prepare($sql_query);
          $sql->execute();

          $numRows = $sql->fetchAll();
          if(count($numRows)>0)
          {
              foreach($numRows as $row)
              {
                  $fid = $row['fid'];

                  echo "<option value='$fid'>$fid</option>";
              }
          }
          ?>
      </select>

      <label> <b>Price</b></label>
      <input id="price" type="text" name="price for decorations" required>
	
	<table id="foodtable" style="width:50%">
  <tr>
    <th>Food Id</th>
    <th>Description</th> 
	<th>Price(Rs)</th>
  </tr>
  <?php
  $sql_query = "SELECT fid,descrp,price FROM tb_food order by fid";
  $sql = $conn->prepare($sql_query);
  $sql->execute();

  $numRows = $sql->fetchAll();
  if(count($numRows)>0)
  {
      foreach($numRows as $row)
      {
          $fid = $row['fid'];
          $descrp = $row['descrp'];
          $price = $row['price'];
          echo "<tr>
                    <td>$fid</td>
                    <td>$descrp</td>
                    <td>$price.00</td>
                </tr>";
      }
  }
  ?>
    </table>
	
	<br><label for="decoid"><b> Decoration Id</b></label>
    <select id="deco" onchange="loadData('deco','dtable','dprice')" name="txt_did">
        <?php
        $sql_query = "SELECT did FROM tb_deco order by did";
        $sql = $conn->prepare($sql_query);
        $sql->execute();

        $numRows = $sql->fetchAll();
        if(count($numRows)>0)
        {
            foreach($numRows as $row)
            {
                $did = $row['did'];

                echo "<option value='$did'>$did</option>";
            }
        }
        ?>
    </select>
<label> <b>Price</b></label>
    <input id="dprice" type="text" name="price for decorations" required>
	
	
	<h4>fresh flowers:</h4>
	<table id="dtable" style="width:50%">
  <tr>
    <th>Decoration Id</th>
    <th>Description</th> 
	<th>Price(Rs)</th>
  </tr>
        <?php
        $sql_query = "SELECT * FROM `tb_deco` WHERE `plus` LIKE 'fresh flowers' ORDER BY `did` ASC";
        $sql = $conn->prepare($sql_query);
        $sql->execute();

        $numRows = $sql->fetchAll();
        if(count($numRows)>0)
        {
            foreach($numRows as $row)
            {
                $did = $row['did'];
                $descrp = $row['descrp'];
                $plus = $row['plus'];
                $price = $row['price'];
                echo "<tr>
                    <td>$did</td>
                    <td>$descrp</td>
                    <td>$price.00</td>
                </tr>";
            }
        }
        ?>
 </table>
 
 
 <h4>Artificial flowers:</h4>
	<table id="dtable1" style="width:50%">
  <tr>
    <th>Decoration Id</th>
    <th>Description</th> 
	<th>Price(Rs)</th>
  </tr>

        <?php
        $sql_query = "SELECT * FROM `tb_deco` WHERE `plus` LIKE 'artificial flowers' ORDER BY `did` ASC";
        $sql = $conn->prepare($sql_query);
        $sql->execute();

        $numRows = $sql->fetchAll();
        if(count($numRows)>0)
        {
            foreach($numRows as $row)
            {
                $did = $row['did'];
                $descrp = $row['descrp'];
                $plus = $row['plus'];
                $price = $row['price'];
                echo "<tr>
                    <td>$did</td>
                    <td>$descrp</td>
                    <td>$price.00</td>
                </tr>";
            }
        }
        ?>

    </table>
 
 <h4>baloons dust and crapes:</h4>
	<table id="dtable2" style="width:50%">
  <tr>
    <th>Decoration Id</th>
    <th>Description</th> 
	<th>Price(Rs)</th>
  </tr>

      <?php
      $sql_query = "SELECT * FROM `tb_deco` WHERE `plus` LIKE 'baloons' ORDER BY `did` ASC";
      $sql = $conn->prepare($sql_query);
      $sql->execute();

      $numRows = $sql->fetchAll();
      if(count($numRows)>0)
      {
          foreach($numRows as $row)
          {
              $did = $row['did'];
              $descrp = $row['descrp'];
              $plus = $row['plus'];
              $price = $row['price'];
              echo "<tr>
                    <td>$did</td>
                    <td>$descrp</td>
                    <td>$price.00</td>
                </tr>";
          }
      }
      ?>

 </table>
 
	<br><label for="supid"><b>Technical support ID</b></label>
      <select id="tech" onchange="loadData('tech','ttable','tprice')" name="txt_tid">
          <?php
          $sql_query = "SELECT tid FROM tb_technical order by tid";
          $sql = $conn->prepare($sql_query);
          $sql->execute();

          $numRows = $sql->fetchAll();
          if(count($numRows)>0)
          {
              foreach($numRows as $row)
              {
                  $tid = $row['tid'];

                  echo "<option value='$tid'>$tid</option>";
              }
          }
          ?>
      </select>
<label <b>Price</b></label>
    <input id="tprice" type="price" name="price for decorations" required>
	
	<table id="ttable" style="width:50%">
  <tr>
    <th>Technical SupportId</th>
    <th>Description</th> 
	<th>Price(Rs)</th>
  </tr>

     <?php
     $sql_query = "SELECT * FROM tb_technical order by tid";
     $sql = $conn->prepare($sql_query);
     $sql->execute();

     $numRows = $sql->fetchAll();
     if(count($numRows)>0)
     {
         foreach($numRows as $row)
         {
             $tid = $row['tid'];
             $descrp = $row['descrp'];
             $price = $row['price'];
             echo "<tr>
                    <td>$tid</td>
                    <td>$descrp</td>
                    <td>$price.00</td>
                </tr>";
         }
     }
     ?>
  </table>
 
 <br><label for="total"><b> Total Price</b></label>
    <br><input type="text"  id="total" name="txt_total" required>
	

    <div class="request">
      <button type="submit" class="requestbutton" name="btn_rqst" value="SAVE">Request</button>
    </div>
  </div>
</form>
 <script>
     function loadData(id_name,table,price){

         if(table=="dtable"){
             loadData('deco','dtable1','dprice');
             loadData('deco','dtable2','dprice');

         }
         for (i=0;i<document.getElementById(table).getElementsByTagName("tr").length;i++){
             if(document.getElementById(id_name).value==document.getElementById(table).rows[i].cells[0].innerHTML){
                 if(table=="foodtable"){
                     document.getElementById(price).value=document.getElementById(table).rows[i].cells[2].innerHTML+" X "+document.getElementById("packs").value ;
                 }
                 else{
                     document.getElementById(price).value=document.getElementById(table).rows[i].cells[2].innerHTML;
                 }

             }
         }
         setTotal();
     }
     function loadPrice() {
         if(document.getElementById("txt-time").value=="morning"){
                    document.getElementById("audiprice").value="2000";
         }
         if(document.getElementById("txt-time").value=="evening"){
             document.getElementById("audiprice").value="5000";
         }
         if(document.getElementById("txt-time").value=="day"){
             document.getElementById("audiprice").value="8000";
         }
         setTotal();

     }
     function setTotal() {
         $noPacks=document.getElementById("packs").value;
         $foodPrice=document.getElementById("price").value.split(" ")[0];
         $DecoPrice=document.getElementById("dprice").value;
         $techPrice=document.getElementById("tprice").value;
         $audiPrice=document.getElementById("audiprice").value;
         console.log();
         document.getElementById("total").value=Number($audiPrice)+(Number($noPacks)*Number($foodPrice))+Number($DecoPrice)+Number($techPrice)
        console.log(document.getElementById("datepicker").value);
     }


 </script>

 </body>
</html>