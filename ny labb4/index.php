<?php
/*

session_start();

require_once("HTMLView.php");
require_once("LoginController.php");

require_once("LoginModel.php");
require_once("LoginView.php");



$output = new  HTMLView();
$loginController = new \controller\LoginController();
$registerController = new \controller\RegisterController();
$loginmodel = new \model\LoginModel();
$loginview = new \view\LoginView($loginmodel);
$registerview = new \view\RegisterView();

// Kollar ifall användaren tryck på "Registrera ny användare".
if($loginview->registerClick() === true){
	$htmlBody = $registerController->doControll();
}
else{
	$htmlBody = $loginController->doControll();
}

$output->echoHTML($htmlBody);



*/
session_start();
require_once("LoginController.php");
require_once("HTMLView.php");
require_once("LoginModel.php");
require_once("LoginView.php");



$output = new  HTMLView();
$loginController = new controller\LoginController();
//$registerController = new RegisterController();
$loginmodel = new model\LoginModel();
$view = new \view\LoginView($loginmodel);
//$registerview = new RegisterView();

// Kollar ifall användaren tryck på "Registrera ny användare".
if($view->registerClick() === true){
//	$htmlBody = $loginController->doControll();
	$htmlBody= $loginController->doRegisterControll();
}
else{
	$htmlBody = $loginController->doControll();
}

$output->echoHTML($htmlBody);


/*
$lC = new LoginController();
$htmlBody=$lC->doControll();
//$loginview = new \LoginView(); 	
$view = new HTMLView();
$view->echoHTML($htmlBody);

if($view->registerClick() === true){
	$htmlBody = $view->doControll();
}else{
$htmlBody = $view->doControll();
    
}
$view->echoHTML($htmlBody);
*/

?>



