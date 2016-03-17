<?php
namespace controller;

require_once("LoginModel.php");
require_once("LoginView.php");
require_once("UserAgent.php");
require_once("RegisterRepository.php");
require_once("User.php");

class LoginController {
    private $model;
    private $view;
    private $registerrepository;
    private $UserAgent;
    
    public function __construct()
    {   
        $this->model = new \model\LoginModel();
        $this->view = new \view\LoginView($this->model);
        $this->UserAgent = new \UserAgent();
        $this->registerrepository = new \model\RegisterRepository();
        //$this->view = new \LoginView();
    }
    
    public function doControll()
    {
      $uAgent=$this->UserAgent->getUserAgent();
        
        if($this->model->checkRegister()){
            $this->view->successfullRegister();
        }
        if($this->view->userIsRemembered() and !$this->model->authenticate($uAgent)){
            try {
                // Hämtar o kontrollerar o jämför dem med sparad data.
                $this->model->checkLoginWithCookies($this->view->getCookieName
                    (), $this->view->getCookiePassword(),$uAgent);
               
                $this->view->viewMessage("Inloggningen lyckades via cookies!");                     
            } catch (\Exception $e) {
              //  $this->view->deleteCookie();
                $this->view->viewMessage($e->getMessage());
            }
        }
       //om användaren redan är inloggad.
       if ($this->view->UserPressLogout()) {
           $this->view->deleteCookie();
           $this->model->logOut();
           $this->view->logoutMessage();
       }
       //om användaren trycker på logga in.
        if ($this->view->didUserLogin())
        {
            try{
                    
                $clientUsername = $this->view->getUserName();
                $clientPassword = $this->view->getPassword();
                $this->model->checkLogin($clientUsername,$clientPassword,$uAgent);

                if ($this->view->RememberCheckbox()){
                    $this->view->saveCookie($clientUsername,$clientPassword);
                  
                    $this->view->viewMessage("Inloggning lyckades och vi kommer ihåg dig nästa gång");
                }
                else{
                 //   
                    $this->view->viewMessage("Inloggningen lyckades!");
                }
             }      
                    catch (\Exception $e) {
                $this->view->deleteCookie();
                $this->view->viewMessage($e->getMessage());
                
            }
        }
        // Om inloggningen lyckades .
       if($this->model->authenticate($uAgent)){
            return $this->view->showUserView();
        }
        // Annars visa inloggningssidan.
        if($this->model->authenticate($uAgent)===false){
            return $this->view->showLoginView();
        
        //     return $this->view->showLoginView();
        
        }
         
                
     
        
    }
    /*controller för register*/
      public function doRegisterControll(){
          	// Hanterar indata.

		// Om användaren tryckt på Registera.
		if($this->view->submitregister()){
			try{
                    
				// Hämtar den inmatade datan.
				$registerData =new \model\User($this->view->getRegUserName(), 
				$this->view->getRegPassword(), 
				$this->view->getRegRepPassword());
				
			
				
				
				// Kollar ifall användarnamnet redan existerar i databasen.
				if ($this->registerrepository->usernameExists($this->view->getRegUserName())) {
		            throw new \AlreadyExistsException("Errorcode: ", 201);
				}
				// Skapar ny användare med den inmatade datan.
				$this->registerrepository->create($registerData);
				$this->model->setSession("success");
				$this->view->backToLogin();	
			}
			// Exceptions som skickar vidare de olika felkoderna till vyn.
			catch (TooShortException $e) {
				$this->view->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\InvalidCharException $e) {
				$this->view->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\NoMatchException $e) {
				$this->view->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\AlreadyExistsException $e) {
				$this->view->setMessage($e->getMessage(), $e->getCode());
			}
			catch (\Exception $e) {
				$this->view->setMessage($e->getMessage(), $e->getCode());
			}
		}

	// Generar utdata.

		return $this->view->registerView();

	
      }

    
}
