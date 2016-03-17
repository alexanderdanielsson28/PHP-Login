<?php

namespace model;
require_once("CustomExceptions.php");
require_once("LoginRepository.php");

class LoginModel{
	private $sessionUserAgent;
	private static $username = "username";
	private static $password = "password";
	public $message = "";
	private $sessionLoginData = "LoginModel::LoggedInUserName";
	private $view;
    private $loginrepository;
	
        public function __construct(){
		       $this->loginrepository = new \model\LoginRepository();
	   }
		
	public function authenticate($uAgent)
	{
		
			if(isset($_SESSION[$this->sessionLoginData]) && $_SESSION[$this->sessionUserAgent]
			    === $uAgent){
				return true;
			
			}
			else{
				return false;
			}
			
		

	}
	public function getDateTime(){
		date_default_timezone_set('Europe/Stockholm');
		setlocale(LC_ALL, "sv_SE");
		$day=date('D');
		if ($day==="Mon") {
			$wek="måndag";
		}
		if ($day==="Tue") {
			$wek="Tisdag";
		}
		if ($day==="Wed") {
			$wek="Onsdag";
		}
		if ($day==="Thu") {
			$wek="Torsdag";
		}
		if ($day==="Fri") {
				$wek="Fredag";
			}
		if ($day==="Sat") {
				$wek="Lördag";		
			}
		if ($day==="Sun") {
				$wek="Söndag";			
			}
		//Månader 
		$month=date('M');
		if ($month==="Jan") {
				$Thismonth="Januari";
			}
		if ($month==="Feb") {
				$Thismonth="Februari";
			}
		if ($month==="Mar") {
				$Thismonth="Mars";
			}
		if ($month==="Apr") {
				$Thismonth="April";
			}
		if ($month==="May") {
				$Thismonth="Maj";
			}
		if ($month==="Jun") {
				$Thismonth="Juni";
			}
		if ($month==="Jul") {
				$Thismonth="Juli";
			}
		if ($month==="Aug") {
				$Thismonth="Augusti";
			}
		if ($month==="Oct") {
				$Thismonth="Oktober";
			}
		if ($month==="Nov") {
				$Thismonth="November";
			}
		if ($month==="Dec") {
				$Thismonth="December";
			}													
	
		$date = strftime("den %d");
		
		$year = strftime("år %Y.");
		$time = strftime("Klockan är [%H:%M:%S].");
	return "$wek $date  $Thismonth  $year  $time";
	}
	public function getLoggedInUser(){
		return $_SESSION[$this->sessionLoginData];
	}

	public function checkLogin($clientUsername,$clientPassword, $uAgent){
		    $user = $this->loginrepository->getUserByUsername($clientUsername);
		    
		if (strtolower($clientUsername)===strtolower($user[self::$username]) and $this->cryptPassword($clientPassword) === $user[self::$password]) {
			
			$_SESSION[$this->sessionUserAgent]=$uAgent;
			$_SESSION[$this->sessionLoginData] = $user[self::$username];
			return true;
		}
		else{
			throw new \Exception("Felaktigt användarnamn och/eller lösenord");
			
		}
	}

	public function checkLoginWithCookies($clientUsername, $clientPassword, $uAgent){
		//$time = $this->loadCookie();
		$user = $this->loginrepository->getUserByUsername($clientUsername);
		
		if ($clientPassword === $user[self::$password]) {
			
			$_SESSION[$this->sessionUserAgent]=$uAgent;
			$_SESSION[$this->sessionLoginData]=$clientUsername;
			return true;
		}else{
			throw new \Exception("Felaktigt information i kakan!");
		}
	}
	
		// Sparar kakan, samtidigt sparas förfallotiden som returneras.
	public function saveCookie($value){
	    file_put_contents("Cookietime",$value);
	}

	// Laddar kakan.
	public function loadCookie(){
	    return file_put_contents("Cookietime");
	}

	// Tar bort kakan.
/*	public function deleteCookie($name){
		setcookie ($name, "", time() - 3500);
	}
*/	
	
	
	
	
	public function logOut(){
		unset($_SESSION[$this->sessionLoginData]);
		
	}
	public function checkRegister(){
	    return isset($_SESSION['session']);
	}
	public function setSession($input){
		$_SESSION['session'] = $input;
	}
	public function deleteSession(){
	    unset($_SESSION["session"]);
	}
/*	public function cryptPassword($password){
$salt = "blommprinsen28";
return sha1($salt . $password);
}*/
/*

private $regUsername;
private $regPassword;
const regEx = '/[^a-z0-9\-_\.]/i';
const minUsername = 3;
const minPassword = 6;
// Validerar och sätter användarnamn och lösenord.

public function __construct($regUsername, $regPassword, $regRepPassword){
     $this->loginrepository = new LoginRepository();
    
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
*/
 public function cryptPassword($regPassword){
 $salt = "blommprinsen28";
return sha1($salt . $regPassword);
}




	
	




}