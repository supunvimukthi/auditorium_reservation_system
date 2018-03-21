<?php
session_start();
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


?>
<!DOCTYPE html>
<html>

<link rel="stylesheet" href="css/reservation.css" type="text/css">
<link rel="stylesheet" href="css/nav.css" type="text/css">


    <ul>
        <li><a href="login.php?logout='1'">Logout</a></li>
        <li><a href="request.php">Requests</a></li>
        <li id="report"><a href="reports.php">Reports</a></li>
        <li id="add"><a href="add.php">Add Users</a></li>
        <li id="edit"><a href="edit.php">Edit Users</a></li>
        <li id="delete"><a href="delete.html">Delete Users</a></li>
    </ul>

</head>
<body>

<div class="requests">
    <h2>Requests</h2>

    <table id="table" style="width:50%">
        <tr id="head">
            <th>Customer</th>
            <th>Date</th>
            <th>Time</th>
            <th>Packs</th>
            <th>Purpose</th>
            <th>Total</th>
            <th>Approve</th>


        </tr>

    <?php
    use Mailgun\Mailgun;
    require 'vendor/autoload.php';
    if($_SESSION['type']=='decoration' or $_SESSION['type']=='food' or $_SESSION['type']=='technical'){
        echo "<script>
    
        document.getElementById(\"report\").style.visibility=\"hidden\";
        document.getElementById(\"add\").style.visibility=\"hidden\";
        document.getElementById(\"edit\").style.visibility=\"hidden\";
        document.getElementById(\"delete\").style.visibility=\"hidden\";
        </script>";
    }
    if(isset($_POST['approve'])){
        $no=$_POST['approve'];
        $sql_query = "UPDATE tb_reservation SET approved=1 WHERE no=$no ";
        $sql = $conn->prepare($sql_query);
        $sql->execute();
        //echo "<script type='text/javascript'>document.getElementById('$no').disabled=true</script>";
        echo "<script type='text/javascript'>alert('Reservation Approved ');</script>";
        $sql_query = "SELECT s.uid,s.date,s.time,s.packs,s.purpose,s.total,f.descrp as fdesc,f.price as fprice,t.descrp as tdesc,t.price as tprice,d.descrp as ddesc,d.plus,d.price as dprice from tb_reservation as s,tb_food as f,tb_technical as t,tb_deco as d WHERE s.fid=f.fid AND s.tid=t.tid AND s.did=d.did and s.no=$no";
        $sql = $conn->prepare($sql_query);
        $sql->execute();
        $numRows = $sql->fetchAll();
         if(count($numRows)>0) {
             foreach($numRows as $row){
                 $date=$row[1];
                 $email=$row[0];
                 $time=$row[2];
                 $pax=$row[3];
                 $purpose=$row[4];
                 $Fdesc=$row[6];
                 $Fprice=$row[7];
                 $Tdesc=$row[8];
                 $Tprice=$row[9];
                 $Ddesc=$row[10];
                 $Dplus=$row[11];
                 $Dprice=$row[12];
                 $total=$row[5];
             }
        }


          # Instantiate the client.
        $mgClient = new Mailgun('key-2e3ef76b649c6ea9e17d4ce2ab948af2');
        $domain = "sandbox438699011a3542ab8c394ed404905852.mailgun.org";

         # Make the call to the client.
        $result = $mgClient->sendMessage("$domain",
            array('from' => 'Auditorium Reservation <postmaster@sandbox438699011a3542ab8c394ed404905852.mailgun.org>',
                'to' => '<'.$email.'>',
                'subject' => 'Reservation Confirmation',
                'text' => "This is to confirm that your reservation on ".$date."-".$time." for ".$pax." people has been made for the purpose of ".$purpose.
                    " as stated by you.\r\n Food : ".$Fdesc." - ".(int)$Fprice*(int)$pax."\r\n Decoration : ".$Ddesc.$Dplus." - ".$Dprice."\r\n Technical : ".$Tdesc." - ".$Tprice."
                      \r\n Total : ".$total." \r\n From Auditorium Reservation"));
    }




   // if($_SESSION['type']=='decoration'){}
    //  if($_SESSION['type']=='tech'){}
    $sql_query = "SELECT * FROM tb_reservation ORDER BY no";
    $sql = $conn->prepare($sql_query);
    $sql->execute();

    $numRows = $sql->fetchAll();

    if(count($numRows)>0)
    {   echo  "<script>var sd=1;</script>";
        foreach($numRows as $row)
        {
            $no = $row['no'];
            $uid = $row['uid'];
            $date = $row['date'];
            $time = $row['time'];
            $packs = $row['packs'];
            $purpose = $row['purpose'];
            $fid = $row['fid'];
            $did = $row['did'];
            $tid = $row['tid'];
            $total = $row['total'];
            $approved=$row['approved'];

            echo "<tr>
                    <td>$uid</td>
                    <td>$date</td>
                    <td>$time</td>
                    <td>$packs</td>
                    <td>$purpose</td>
                    <td>$total.00</td>";

                    if($approved==0){
                        echo "<td><form action='request.php' method='post'><button style='size: auto;width: fit-content'  name='approve' id='$no' type='submit' value=$no>Approve</button> </form></td>";
                    }
                    else{
                        echo "<td><form action='request.php' method='post'><button type='button' disabled style='background-color:darkgrey;size: auto;width: fit-content'  name='approve' id='$no' type='submit' value=$no>Approve</button> </form></td>";
                    }

                    if($_SESSION['type']=='food'){
                        echo "<script> document.getElementById('$no').innerHTML='Notice';if (sd==1){var header = document.getElementById('table').createTHead();header.innerHTML='Food';document.getElementById('head').appendChild(header);sd++;}</script>";
                        $sql_query = "SELECT * FROM tb_food where fid=$fid ORDER BY fid";
                        $sql = $conn->prepare($sql_query);
                        $sql->execute();

                        $numRows = $sql->fetchAll();
                        if(count($numRows)>0)
                        {
                            foreach($numRows as $row)
                            {
                                $food = $row['descrp'];
                            }
                        }
                        echo "<td>$food</td>";

                    }
                    if($_SESSION['type']=='decoration'){
                        echo "<script>  document.getElementById('$no').innerHTML='Notice';if (sd==1){var header = document.getElementById('table').createTHead();header.innerHTML='Deco';document.getElementById('head').appendChild(header) ;sd++;}</script>";;
                        $sql_query = "SELECT * FROM tb_deco where did=$did ORDER BY did";
                        $sql = $conn->prepare($sql_query);
                        $sql->execute();

                        $numRows = $sql->fetchAll();
                        if(count($numRows)>0)
                        {
                            foreach($numRows as $row)
                            {
                                $deco = $row['descrp'];
                                $plus=$row['plus'];
                            }
                        }
                        echo "<td>$deco+','+$plus</td>";

                    }
                    if($_SESSION['type']=='technical'){
                        echo "<script>  document.getElementById('$no').innerHTML='Notice';if (sd==1){var header = document.getElementById('table').createTHead();header.innerHTML='Technical';document.getElementById('head').appendChild(header);sd++;}</script>";;
                        $sql_query = "SELECT * FROM tb_technical where tid=$tid ORDER BY tid";
                        $sql = $conn->prepare($sql_query);
                        $sql->execute();

                        $numRows = $sql->fetchAll();
                        if(count($numRows)>0)
                        {
                            foreach($numRows as $row)
                            {
                                $tech= $row['descrp'];


                            }
                        }
                        echo "<td>$tech</td>";

                    }
            echo  "</tr>";
        }

    }
    ?>
    </table>
</div>

</body>
</html>