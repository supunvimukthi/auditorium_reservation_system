<?php
use Mailgun\Mailgun;
if(isset($_POST['mail'])) {
    require 'vendor/autoload.php';

    $name=$_POST['name'];
    $email=$_POST['email'];
    $subject=$_POST['subject'];

# Instantiate the client.
    $mgClient = new Mailgun('key-2e3ef76b649c6ea9e17d4ce2ab948af2');
    $domain = "sandbox438699011a3542ab8c394ed404905852.mailgun.org";

# Make the call to the client.
    $result = $mgClient->sendMessage("$domain",
        array('from' => 'Auditorium Reservation <postmaster@sandbox438699011a3542ab8c394ed404905852.mailgun.org>',
            'to' => ''.$name.' <'.$email.'>',
            'subject' => 'Custom Inquiry',
            'text' => ''.$subject.' From '.$name.' --- '.$email));

}
?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/contact.css" type="text/css">
<link rel="stylesheet" href="css/nav.css" type="text/css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<ul>
  <li><a href="home.html">About Us</a></li>
  <li><a href="login.php">Login</a></li>
  <li><a href="terms.html">Terms & Privacy Policy</a></li>
  <li><a href="gallery.html">Gallery</a></li>
  <li><a href="contact.php">Contact</a></li>
  
</ul>
</head>
<body>


<h3>Contact us</h3>

<div class="contactform">
  <form >
    <label for="name"> Name</label>
    <input type="text" id="name" name="name" placeholder="enter your name">

    <label for="email">email</label>
    <input type="text" id="lname" name="email" placeholder="enter your email">

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write your message" style="height:200px"></textarea>
<input type="submit" formmethod="post" value="Submit" name="mail">
  </form>
</div>

</body>
</html>