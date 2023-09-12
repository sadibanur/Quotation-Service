<!--
This is the home page for Final Project, Quotation Service.
It is a PHP file because later on you will add PHP code to this file.

File name: register.php

Authors: Rick Mercer and Sadiba Nusrat Nur
-->
<?php 
session_start()
 
?>
<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body >
<h1>Register</h1>

<form class="registerLogin" action="controller.php" method="post">
<input type="text" id="username" name="registerUsername"
    placeholder="Username" required></input><br><br>
<input type="password" id="registerPassword" name="registerPassword"
    placeholder="Password" required></input><br><br>
    <button type="submit" name="register">Submit</button><br>
    
 <?php 
 
 if (isset ( $_SESSION ['registerError'] ) ) {
     echo "<h3>" . $_SESSION['registerError'] . "</h3>";
 }
 
 unset($_SESSION ['registerError']);

 
 ?>
  </form>
 </body>
 

</html>