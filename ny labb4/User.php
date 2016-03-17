<?php
namespace model;
require_once("CustomExceptions.php");

class User{
    

private $regUsername;
private $regPassword;
const regEx = '/[^a-z0-9\-_\.]/i';
const minUsername = 3;
const minPassword = 6;
// Validerar och sätter användarnamn och lösenord.

public function __construct($regUsername, $regPassword, $regRepPassword){
   
    
// Om både användarnamn och båda lösenorden är för korta.
if(mb_strlen($regUsername) < self::minUsername && mb_strlen($regPassword) < self::minPassword && mb_strlen($regRepPassword) < self::minPassword){
throw new \TooShortException("Errorcode: ", 202);
}
// Om användarnamnet är för kort.
if(mb_strlen($regUsername) < self::minUsername){
throw new \TooShortException("Errorcode: ", 203);	
}
// Om användarnamnet innehåller ogiltiga tecken.
if(preg_match(self::regEx, $regUsername)){
$regUsername = preg_replace(self::regEx, "", $regUsername);
throw new \InvalidCharException($regUsername, 204);	
}
// Om lösenordet är för kort.
if(mb_strlen($regPassword) < self::minPassword || mb_strlen($regRepPassword) < self::minPassword){
throw new \TooShortException("Errorcode: ", 206);	
}
// Om lösenorden är olika.
if($regPassword !== $regRepPassword){
throw new \NoMatchException("Errorcode: ", 205);
}
$this->regUsername = $regUsername;
$this->regPassword = $this->cryptPassword($regPassword);
}


public function getUsername(){
return $this->regUsername;
}
public function getPassword(){
return $this->regPassword;
}

 public function cryptPassword($regPassword){
$salt = "blommprinsen28";
return sha1($salt . $regPassword);
}

}