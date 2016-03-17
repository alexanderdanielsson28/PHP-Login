<?php

namespace view;
require_once("CookieHandle.php");
require_once("CustomExceptions.php");
require_once("User.php");	
class LoginView{
	 private $model;
	 private $cookieUsername;
	 private $cookiePassword;
	 private $username = "LoginView::Username";
	 private $password = "LoginView::Password";
	 private $message;
	 private $regUsername = "LoginView::RegUserName";
	 private $regPassword="LoginView::RegPassword";
	 private $regRepPassword="LoginView::RegRepPassword";
	 private $messages;
	 private $User;
	 private $p =1;
	 
	 

	public function __construct(\model\LoginModel $model){
		$this->model = $model;
		$this->cookieUsername = new \CookieHandle();
		$this->cookiePassword = new \CookieHandle();
		

	}
	public function session(){
	  return  $_SESSION["saveuser"]=$this->regUsername;
	}
	
	
	// om användare tryckt logga in
	public function didUserLogin(){
		
			if (isset($_POST['LoginView::presslogin'])){
				return $_POST["LoginView::presslogin"];
			}
			else{
				return false;
			}
	}

	public function backToLogin(){
	header("Location:?");
	}
	public function successfullRegister(){
		$this->viewMessage("Registrering av ny användare lyckades!");
		$this->model->deleteSession();
		
	}
	 
//	om användare valt i håll mig inloggad
	public function RememberCheckbox(){
			if(isset($_POST["LoginView::checked"])){
				return true;
			}
			else{
				return false;
			}
	}
		//sparar kakor
	public function saveCookie($username, $password){
			$this->cookieUsername->saveCookie($this->username,$username);
			//($this->cookiePassword->saveCookie($this->password, md5($password)));	
			$this->model->saveCookie($this->cookiePassword->saveCookie($this->password, $this->model->cryptPassword($password)));
		//	return $this->cookieUsername->loadCookie($this->username);
		}

	public function getCookieName(){

		return $this->cookieUsername->loadCookie($this->username);
	}	

	public function getCookiePassword(){

			return $this->cookiePassword->loadCookie($this->password);
		}
	public function getUsername(){
			if (empty($_POST["$this->username"])) {
               // $this->messages("Användarnamn saknas");
				//$this->viewMessage("Användarnamn saknas");
				throw new \Exception("Användarnamn saknas");
				}
				else{
					return $_POST["$this->username"];
				}
		

}
	public function getPassword(){

	    
			if (empty($_POST["$this->password"])) {
		
			//	$this->viewMessage("Lösenord saknas");	
				throw new \Exception("Lösenord saknas");
				
			}else{
				return $_POST["$this->password"];
			}
			
		}
		
		//visar meddelande beroende på vad input är.
	public function viewMessage($message){
			if (isset($message)) {
				$this->message = $message;
			}
			else{
				$this->message="<p>".$message."</p>";
			}

		}
	public function saveusername(){
        
        return isset($_POST['$this->uservalues']);
        
	    
	}
	
		public function getRegUserName(){
		    //return $_POST["regUsername"];
		    $saveuser=$_POST[$this->regUsername];
		//return $_POST[$this->username];
	    $_SESSION["user1"]=$saveuser;
	    return $saveuser;
		}
		public function getRegPassword(){
		    return $_POST["$this->regPassword"];
		}
		public function getRegRepPassword(){
		    return $_POST["$this->regRepPassword"];
		}
		    
		//meddelande om användaren loggar ut
	public function logoutMessage(){
			$this->viewMessage("du har nu loggat ut");
		}
		
		// när kakorna ska raderas bort
	public function deleteCookie(){
		
		$this->cookieUsername->deleteCookie($this->username);
		$this->cookiePassword->deleteCookie($this->password);
		}

	public function userIsRemembered()
		{
		if($this->cookieUsername->loadCookie($this->username) && $this->cookiePassword->loadCookie($this->password)) {
				return true;
			}
			else{
				return false;
			}
		}
			//kolla om användaren tyckt logga ut
		public function UserPressLogout(){
			if (isset($_POST["View::logout"])) {
				return $_POST["View::logout"];
			}else{
				return false;
			}
		}
		public function newUserSuccses(){
		    $p =2;
		   return $this->messages("Registrering av ny användare lyckades");
		 
		}
		public function submitregister(){
		   return isset($_POST["LoginView::register"]);
		    
		    
		}
public function registerClick(){
  return isset($_GET["register"]);
}
public function setMessage($e, $c){
		if($c == 201){
			$this->messages = "Användarnamnet finns redan registrerat i databasen.";
		}
		if($c == 202){
			$this->messages = "Användarnamnet är för kort. Minst 3 tecken.</p>
								 <p>Lösenorden är för korta. Minst 6 tecken.";
		}
		if($c == 204){		
			$this->messages = "Användarnamnet innehöll ogiltiga tecken.";
			$_POST[$this->regUsername] = $e;
		}
		if($c == 203){		
			$this->messages = "Användarnamnet är för kort. Minst 3 tecken.";
		}
		if($c == 206){		
			$this->messages = "Lösenorden är för korta. Minst 6 tecken.";
		}
		if($c == 205){		
			$this->messages = "Lösenorden är olika varandra.";
		}
	}
	public function getMessage(){
		return "<p>" . $this->messages . "</p>";
	}

	public function showLoginView(){
	/*	if(isset($this->message)){
		$status = $this->getMessage();
		}	
	*/		
			
		    $_SESSION["user1"] = isset($_SESSION["user1"]) ? $_SESSION["user1"] : "";
            $this->save = $_SESSION["user1"];
            $_SESSION["user1"] = "";
			
		//	 $save=$_SESSION["user1"];
			$datetime=$this->model->getDateTime();
			

			$ret ="<h1>Laboration 2 -inloggning - ad222in</h1>";
            
            
			$ret.="<h2>Ej inloggad</h2>";
            $ret.="<p><a href='?register'>Registrera ny användare</a></p>";
			$ret.="
					<fieldset>
			
			
						<legend>Logga in här!</legend>
		
						";
			//$status	$status	$messages
				$ret.="<p>$this->message";
			
			
		   
		//	$ret.="
		//			<form action='?login' method='post'>";
			$ret.="<form action='?login' method='post'>";
		if($this->save){
		    
		$ret.="
            
                Username
                <input type='text' name='$this->username' value='$this->save'>";
		}else
		{
		    
		
        //        if($this->save);
          //  $ret.="value={$this->save}";

			//	if(newUserSuccses(){
				    
			//	}    
			                        
		
		  /* if(!empty($this->newUserSuccses())){
		  $uservalue=$this->saveusername();
			  $ret.="Användarnamn:<input type='text' name='$this->username' value='$uservalue'>";
			*/	 	
		   
			
			    
			
		//	
			if(empty($_POST["$this->username"])){
				
                $ret.="Användarnamn:<input  type='text' name='$this->username' >";
				
				    
				}else{
				    $uservalue = $_POST[$this->username];
			                	$ret.="Användarnamn:<input  type='text' name='$this->username' value='$uservalue'>";
				    
				}
		}	
			
				//$ret.="Användarnamn:<input  type='text' name='$this->username' value='$save'>";
	       /*    }elseif (isset($save)){
			            $ret.="Användarnamn:<input type='text' name='$this->username' value='$save'>";
			 */   
				
				
					
			//	$uservalues = $_POST["$this->regUsername"];
			//	$uservalues = $_POST[$this->regUsername];
	   /*         $username=$this->getRegUserName();
					    $ret .= "<input id='regUsername' type='text' name='$this->regUsername' value='$uservalues'>";
		
		    $usersaver=$this->getRegUserName();			
			    //$user=$_POST[$this->saveusername];
		
			         $ret .= "<input type='text' name='$this->regUsername' value='$usersaver'>";
			
			var_dump($usersaver);
		*/
			
		
			$ret.="Lösenord:<input type='password' name='$this->password'>
			Håll mig inloggad:<input type='checkbox' name='LoginView::checked'>
			<input type='submit' value='Logga in' name='LoginView::presslogin'>
			</form>
			</fieldset>";
			
			
			
			$ret.="<p>$datetime<p>";
			return $ret;						

	
	}
			public function showUserView(){
			$user=$this->model->getLoggedInUser();
			

			$ret="<h1>Laboration 2 - Inloggning -ad222in</h1>";
			$datetime = $this->model->getDateTime();
			$ret.="<h2>$user är inloggad!</h2>";

			$ret.="$this->message";
			$ret.="
					<form action='?logout' method='post'>
					<input type='submit' value='Logga ut' name='View::logout'>
					</form>";
			$ret.="<p>$datetime</p>";		
			return $ret;		
		}
	
		public function registerView(){
		    
		    
		    $datetime=$this->model->getDateTime();
		    $status = "";
		if(isset($this->messages)){
			$status = $this->getMessage();
		}
		    $ret="<h1>Laboration 4-Inloggning-ad222in</h1>
		    <h2> Ej inloggad: Registrera ny användare</h2>
		    <p><a href='?'>Tillbaka</a></p>
		    
		   <fieldset>
		    <legend>Ange uppgifterna här:</legend>
		  $status
		    
		    
		    <form action='?register' method='post'>
		    Användarnamn:";
		    
		
	        
	        
	        if(empty($_POST["$this->regUsername"])){
						$ret .= " <input  type='text' name='$this->regUsername'>";
					}
					// Annars visa det tidigare inmatade användarnamnet i input.
					else{
						$uservalues = $_POST["$this->regUsername"];
						$ret .= "<input type='text' name='$this->regUsername' value='$uservalues'>";
					}
	       
	     
	        
	         
	        //Lösenord:<input type='password' name="$this->regPassword">
	              
	        $ret.="
	               Lösenord:<input type='password' id='pass' name='$this->regPassword'>
	              Repetera lösenord: <input type='password' name='$this->regRepPassword'>
	               <input type='submit' value='Registrera' name='LoginView::register'>
	              </form>
	              </fieldset>
	        ";
	        
	        $ret.="<p>$datetime</p>";
	        return $ret;
	   
	
		}
		
		}

		