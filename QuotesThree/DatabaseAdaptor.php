<?php
// This class has a constructor to connect to a database. The given
// code assumes you have created a database named 'quotes' inside MariaDB.
//
// Call function startByScratch() to drop quotes if it exists and then create
// a new database named quotes and add the two tables (design done for you).
// The function startByScratch() is only used for testing code at the bottom.
// 
// Authors: Rick Mercer and Sadiba Nusrat Nur
//
class DatabaseAdaptor {
  private $DB; // The instance variable used in every method below
  // Connect to an existing data based named 'first'
  public function __construct() {
    $dataBase ='mysql:dbname=quotes;charset=utf8;host=127.0.0.1';
    $user ='root';
    $password =''; // Empty string with XAMPP install
    try {
        $this->DB = new PDO ( $dataBase, $user, $password );
        $this->DB->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    } catch ( PDOException $e ) {
        echo ('Error establishing Connection');
        exit ();
    }
  }
    
// This function exists only for testing purposes. Do not call it any other time.
public function startFromScratch() {
  $stmt = $this->DB->prepare("DROP DATABASE IF EXISTS quotes;");
  $stmt->execute();
       
  // This will fail unless you created database quotes inside MariaDB.
  $stmt = $this->DB->prepare("create database quotes;");
  $stmt->execute();

  $stmt = $this->DB->prepare("use quotes;");
  $stmt->execute();
        
  $update = " CREATE TABLE quotations ( " .
            " id int(20) NOT NULL AUTO_INCREMENT, added datetime, quote varchar(2000), " .
            " author varchar(100), rating int(11), flagged tinyint(1), PRIMARY KEY (id));";       
  $stmt = $this->DB->prepare($update);
  $stmt->execute();
                
  $update = "CREATE TABLE users ( ". 
            "id int(6) unsigned AUTO_INCREMENT, username varchar(64),
            password varchar(255), PRIMARY KEY (id) );";    
  $stmt = $this->DB->prepare($update);
  $stmt->execute(); 
}
    

// ^^^^^^^ Keep all code above for testing  ^^^^^^^^^


/////////////////////////////////////////////////////////////
// Complete these five straightfoward functions and run as a CLI application


    public function getAllQuotations() {
        // TODO 1: Complete this function
        $query1 = "SELECT * FROM quotations".
                  " ORDER BY rating DESC";
        $stmt = $this->DB->prepare( $query1 );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllUsers(){
        // TODO 2: Complete this function
        $query2 = "SELECT * FROM users";
        $stmt = $this->DB->prepare( $query2 );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function addQuote($quote, $author) {
        // TODO 3: Complete this function
        $query3 = "INSERT INTO quotations (added, quote, author, rating, flagged)".
                  "VALUES (now(), '" . $quote . "', '" . $author . "', 0, '0')";
        $stmt = $this->DB->prepare( $query3 );
        $stmt->execute();
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    }
    
    public function addRating($id) {
        // TODO 3: Complete this function
        $query4 = "UPDATE quotations SET rating = rating + 1".
                  " WHERE id = '". $id . "'";
        $stmt = $this->DB->prepare( $query4 );
        $stmt->execute();
    }
    
    public function substractRating($id) {
        // TODO 3: Complete this function
        $query5 = "UPDATE quotations SET rating = rating - 1".
                  " WHERE id = '". $id . "'";
        $stmt = $this->DB->prepare( $query5 );
        $stmt->execute();
    }
    
    
    public function deleteQuote($id) {
        // TODO 3: Complete this function
        $query6 = "DELETE FROM quotations".
                  " WHERE id = '". $id . "'";
        $stmt = $this->DB->prepare( $query6 );
        $stmt->execute();
    }
    
    public function addUser($accountname, $psw){
        // TODO 4: Complete this function
        $query7 = "INSERT INTO users (username, password) ".
                  "VALUES ('" . $accountname . "', '" . $psw . "')";
        $stmt = $this->DB->prepare( $query7 );
        $stmt->execute();
        //return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   


    public function verifyCredentials($accountName, $psw){
        // TODO 5: Complete this function
        // This function is more difficult than the four above
       $query8 = "SELECT username, password FROM users".
                 " WHERE username = '" . $accountName . "'".
                 " AND password = '" . $psw . "'";
       $stmt = $this->DB->prepare( $query8 );
       $stmt->execute();
       $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
       if (count($arr) != 0) {
           return false;
       }
       return true;    
    }

}  // End class DatabaseAdaptor


?>
