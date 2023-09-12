<!-- 
This is the home page for Final Project, Quotation Service. 
It is a PHP file because later on you will add PHP code to this file.

File name addQuotes.php 
    
Authors: Rick Mercer and Sadiba Nusrat Nur
-->

<!DOCTYPE html>
<html>
<head>
<title>Quotation Service</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body >
<h1>Add a Quote</h1>

<form class="addQuote" action="controller.php" method="post">
 <textarea rows="6" cols="72" id="quote" name="quote"
  placeholder="Enter a new quote.."></textarea><br><br>
 <input type="text" id="author" name="author"
  placeholder="Author"></input><br><br>
 <button>Add Quote</button>
</form>

</body>
</html>
