<?php
session_start();

include ("include/dbcon.inc.php");
if (isset($_POST['queryString']))
{
    $name = $_POST['queryString'];
    $sql_query = "SELECT * FROM tb_customer where fname like '%$name%' OR lname like '%$name%' ";
    $sql = $conn->prepare($sql_query);
    $sql->execute();
    $numRows = $sql->fetchAll();
    if(count($numRows)>0)
    {
        foreach($numRows as $row)
        {
            $result=$row['fname'].' '.$row['lname'];
            echo '<br><li onClick="fill(\''.$result.'\');">'.$result.'</li><br>   ';
        }
    }
    else{
        echo "No such result";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Edit Users</title>
  <link rel="stylesheet" href="css/nav.css" type="text/css">
    <link rel="stylesheet" href="css/edit.css" type="text/css">
  <ul>
    <li><a href="login.php?logout='1'">Logout</a></li>
    <li><a href="request.php">Requests</a></li>
    <li><a href="reports.php">Reports</a></li>
    <li><a href="add.php">Add Users</a></li>
    <li><a href="edit.php">Edit Users</a></li>
    <li><a href="delete.html">Delete Users</a></li>
  </ul>

  <script type="text/javascript" src="jquery-1.2.1.pack.js"></script>
  <script type="text/javascript">
      function lookup(inputString) {
          if(inputString.length == 0) {
              // Hide the suggestion box.
              $('#suggestions').hide();
          } else {
              $.post("edit.php", {queryString: ""+inputString+""}, function(data){
                  if(data.length >0) {
                      $('#suggestions').show();
                      console.log(data.split('<!DOCTYPE html>')[0]);
                      $('#autoSuggestionsList').html(data.split('<!DOCTYPE html>')[0]);
                  }
              });
          }
      } // lookup

      function fill(thisValue) {
          console.log(thisValue);
          $('#inputString').val(thisValue);
          setTimeout("$('#suggestions').hide();", 200);
      }
  </script>

  <style type="text/css">



  </style>

</head>

<body>


<div>
  <form>
    <div>
      Type Name:
      <br />
      <input type="text" size="30" value="" id="inputString" onkeyup="lookup(this.value);" onblur="fill();" />
    </div>


    <div class="suggestionsBox" id="suggestions" style="display: none;height: fit-content">
      <img src="img/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
      <div class="suggestionList" id="autoSuggestionsList">
      </div>
    </div>
  </form>
</div>

</body>
</html>


</html>