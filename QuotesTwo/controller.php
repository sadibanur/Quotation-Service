<?php
// This file contains a bridge between the view and the model and redirects back to the proper page
// with after processing whatever form this code absorbs. This is the C in MVC, the Controller.
//
// Authors: Rick Mercer and Sadiba Nusrat Nur
//  
session_start (); // Not needed until a future iteration

require_once './DatabaseAdaptor.php';

$theDBA = new DatabaseAdaptor();


if (isset ( $_GET ['todo'] ) && $_GET ['todo'] === 'getQuotes') {
    $arr = $theDBA->getAllQuotations();
    unset($_GET ['todo']);
    echo getQuotesAsHTML ( $arr );
}

if (isset ( $_POST ['quote'] ) && isset( $_POST ['author'] ) ) {
    $theDBA->addQuote($_POST['quote'], $_POST['author']);
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


function getQuotesAsHTML($arr) { 
    // TODO 6: Many things. You should have at least two quotes in 
    // table quotes. layout each quote using a combo of PHP and HTML 
    // strings that includes HTML for buttons along with the actual 
    // quote and the author, ~15 PHP statements. This function will 
    // be the most time consuming in Quotes 1. You will
    // need to add css rules to styles.css.  
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
        $result .= "&nbsp;" . "<button name='update' value='delete'>" . "Delete" . "</button>";
        $result .= "</form>";
        $result .= '</div>';
        // Add more code below
    }
    return $result;
}
?>