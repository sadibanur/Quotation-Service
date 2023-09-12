<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Sadiba Nusrat Nur
//  
session_start (); // Not needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'logout') {
   
    unset($_GET ['todo']);
    logout();
    header ( "Location: view.php" );
}

if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ( $arr );
}


if (isset ( $_POST ['quote'] ) && isset( $_POST ['author'] ) ) {
    $quote1 = htmlspecialchars( $_POST ['quote'] );
    $author1 = htmlspecialchars( $_POST ['author'] );
    $theDBA->addQuote( $quote1, $author1 );
    header ( "Location: view.php" ); 
}

if (isset ( $_POST['update'] ) && $_POST['update'] === 'increase') {
    $ID = $_POST['ID'];
    $theDBA->addRating($ID);
    header ( "Location: view.php" );
}
if (isset ( $_POST['update'] ) && $_POST['update'] === 'decrease') {
    $theDBA->substractRating($_POST['ID']);
    header ( "Location: view.php" );
}

if (isset ($_POST['update'] ) && $_POST['update'] === 'delete' ) {
    $theDBA->deleteQuote( $_POST['ID'] );
    header ( "Location: view.php" );
}

if (isset ( $_POST ['registerUsername'] ) && isset( $_POST ['registerPassword'] ) ) {
    $registerUsername = htmlspecialchars( $_POST ['registerUsername'] );
    $registerPassword = htmlspecialchars( $_POST ['registerPassword'] );
   
    if ( $theDBA->verifyCredentials($registerUsername, $registerPassword) === false ) {
        $theDBA->addUser( $registerUsername, $registerPassword );
        header ( "Location: view.php" );
    } else {
        $_SESSION['registerError'] = "Account name taken";
        header ( "Location: register.php" ); 
        
    }
}


if (isset ( $_POST ['loginUsername'] ) && isset( $_POST ['loginPassword'] ) ) {
    $loginUsername = htmlspecialchars( $_POST ['loginUsername'] );
    $loginPassword = htmlspecialchars( $_POST ['loginPassword'] );
    //unset ($_POST ['loginUsername']);
    //unset ($_POST ['loginPassword']);
    if ( $theDBA->verifyCredentials( $loginUsername, $loginPassword ) === true ) {
        $_SESSION ['loginUsername'] = $loginUsername;
        $_SESSION ['addQuote'] = '&nbsp;&nbsp;<a href=" ./addQuote.php" ><button>Add Quote</button></a>';
        $_SESSION ['logout'] = '&nbsp;&nbsp;<button onclick="logout()">Logout</button><br><br>';
        $_SESSION ['message'] = "Hello " . $loginUsername;
        $_SESSION ['delete'] = "&nbsp;<button name='update' value='delete'>Delete</button>";
        header ( "Location: view.php" );
    } else {
       $_SESSION ['loginError'] = "Invalid Account/Password";
       header ( "Location: login.php" );
    }
}

function logout() {
    unset ($_SESSION ['addQuote']);
    unset ($_SESSION ['logout']);
    unset ($_SESSION ['message']);
    unset ($_SESSION ['delete']);
    unset ($_SESSION ['loginUsername']);
    
   session_destroy();
}



function getQuotesAsHTML($arr) { 
    // TODO 6: Many things. You should have at least two quotes in 
    // table quotes. layout each quote using a combo of PHP and HTML 
    // strings that includes HTML for buttons along with the actual 
    // quote and the author, ~15 PHP statements. This function will 
    // be the most time consuming in Quotes 1. You will
    // need to add css rules to styles.css. 
    
    if (isset ( $_SESSION ['loginUsername'] ) ) {
        echo $_SESSION ['addQuote'];
        echo $_SESSION ['logout'];
        
    } else {
        echo '&nbsp;&nbsp;<a href="./register.php" ><button>Register</button></a>';
        echo '&nbsp;&nbsp;<a href="./login.php" ><button>Login</button></a><br><br>';
    }
    
    if (isset ( $_SESSION ['message'] ) ) {
        echo "<h3>" . $_SESSION ['message'] . "</h3>";
    }
   // unset($_SESSION ['message']);
    
    $result = '';
    foreach ($arr as $quote) {
        $result .= '<div class="container">';
        $result .= '"' . $quote ['quote'] . '"'. "<br>". "<br>";
        $result .= "&nbsp;&nbsp;" . "--" . $quote ['author']. "<br>" . "<br>";
        $result .= "<form action= 'controller.php' method='post'>";
        $result .= "<input type='hidden' name='ID' value='" . $quote ['id'] . "'>";
        $result .= "&nbsp;" . "&nbsp;" . "<button name='update' value='increase' id= '" . $quote ['id'] . "'>" . "+" . "</button>" . "&nbsp;";
        $result .= "&nbsp;" . "<span>" . $quote ['rating'] . "</span>" . "&nbsp;&nbsp";
        $result .= "<button name='update' value='decrease'>" . "-" . "</button>" . "&nbsp;";
    
        if (isset ( $_SESSION ['delete'] ) ) {
            $result .= $_SESSION ['delete'];
             
        }
        $result .= "</form>";
        $result .= '</div>';
        $result .= "<br>";
        // Add more code below
    }
    return $result;
    
}


?>