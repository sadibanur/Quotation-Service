<!--
This is the home page for Final Project, Quotation Service.
It is a PHP file because later on you will add PHP code to this file.

File name: login.php

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
<h1>Login</h1>

<form class="registerLogin" action="controller.php" method="post">
<input type="text" id="username" name="loginUsername"
    placeholder="Username" required></input><br><br>
<input type="password" id="password" name="loginPassword"
    placeholder="Password" required></input><br><br>
    <button>Submit</button><br>
    
 <?php 
 
 if (isset ( $_SESSION ['loginError'] ) ) {
     echo "<h3>" . $_SESSION['loginError'] . "</h3>";
 }
 unset($_SESSION ['loginError']);
 //if (isset ( $_GET ['loginError'] ) ) {
 //    echo "<h3>" . $_GET['loginError'] . "</h3>";
// }
 
 ?>
  </form>
 </body>
</html>
