<?php

/**
 * contains properties and methods for "user" database queries
 */

/**
 * Good to know
 * What does :userid mean?
 * Parameter identifier.
 * For a prepared statement using named placeholders,
 * this will be a parameter name of the form :name.
 * For a prepared statement using question mark placeholders,
 * this will be the 1-indexed position of the parameter.
 */

class User
{
  //database connection
  public $con;

  //user properties
  public $userid;
  public $firstname;
  public $lastname;
  public $email;
  public $password;
  public $newpassword;
  public $verificationkey;
  public $verified;
  public $name;



  public function __construct($db)
  {
    $this->con = $db;
  }





  /**
   * Check if the login credentials are correct
   */
  public function checkLogin()
  {
    $query = "SELECT
                  *
                FROM
                  user
                WHERE
                  email = :email
                AND
                 password = :password";

    $stmt = $this->con->prepare($query);

    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);

    $stmt->execute();


    if ($stmt->rowCount() == 1) {
      return $stmt;
    } else {

      return false;
    }
  }

  /** 
   * Creates a new User
   */
  public function create()
  {




    $query = "INSERT INTO
                  user
                VALUES (
                  null,
                  :firstname,
                  :lastname,
                  :email,
                  :password
                  
               
                )";

    $stmt = $this->con->prepare($query);

    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":email", $this->email);
    $stmt->bindParam(":password", $this->password);
 

    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * Deletes a user
   * userid and password needed
   */
  public function delete()
  {

    $query = "DELETE FROM
                  user
                WHERE
                  userid = :userid
                AND
                  password = :password";
                

    $stmt = $this->con->prepare($query);

    $stmt->bindParam(":userid", $this->userid);
    $stmt->bindParam(":password", $this->password);
 
    if ($stmt->execute()) {
      return true;
    } else {
      return false;
    }
  }
  


  public function updateUser()
  {
    /**
   * update the data of a user
   */

    $query = "UPDATE
                  user
                SET
                  firstname = :firstname,
                  lastname  = :lastname
                WHERE
                  userid = :userid";

    $stmt = $this->con->prepare($query);

    $stmt->bindParam(":firstname", $this->firstname);
    $stmt->bindParam(":lastname", $this->lastname);
    $stmt->bindParam(":userid", $this->userid);

    if ($stmt->execute()) {
      
      $getuserquery =  "
                SELECT
                  *
                FROM
                  user
                WHERE
                  user.userid = :userid
      
      ";

      $stmtuser = $this->con->prepare($getuserquery);

      $stmtuser->bindParam(":userid", $this->userid);


      $stmtuser->execute();


      if ($stmtuser->rowCount() == 1) {
        return $stmtuser;
      } else {
        return false;
      }

     
    } else {
      return false;
    }
  }


  public function setname()
  {
    
    $query = "INSERT INTO names VALUES (null, :name )";

    $stmt = $this->con->prepare($query);

    $stmt->bindParam(":name", $this->name);
   

    $stmt->execute();


    if ($stmt) {
      return true;
    } else {

      return false;
    }
  }

  
  /**
   * get all users
   */
  public function getnames()
  {
    $query = "SELECT 
                  *
                FROM
                  names";
               

    $stmt = $this->con->prepare($query);
    
    if ($stmt->execute()) {
      return $stmt;
  } else {

      return false;
  }
 
   
    
  }


  
}
