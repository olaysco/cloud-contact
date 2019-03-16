<?php

include_once '../model/init.php';
include_once 'validate.php';
include_once '../model/user.php';
include_once 'detector.php';

session_start();
$max_impact = 2;
$database = new Database();
$db = $database->getConnection();
$detect = new Detector();
$report = $detect->detect_intrusion($_GET + $_POST + $_REQUEST);
if($detect->impact>$max_impact){
	$_SESSION['report'] = $report;
	header('location: ../error403.php');
	die;
}
if(isset($_POST)){
	
	if($_POST['type'] == 'login'){
		login($_POST, $db);
	}
	elseif($_POST['type'] == 'register'){
		register($_POST, $db);
	}else if($_POST['type'] == 'add-contact'){
		add_contact($_POST, $db);
	}
}
//login function
function login($data, $db){
	$error = [];
	
	if(!validate::isEmail($data["email"])){
		$error["email"] = "invalid email entered";
	}

	if(!validate::isValidPassword($data["password"])){
		$error["password"] = "invalid password entered";
	}
	
	if(empty($error)){
		$email = filter_var($data["email"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_var($data["password"] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$query = "SELECT * FROM `cloudcontact`.`users` WHERE email LIKE ? ";
		$stmt = $db->prepare($query);
		$stmt->execute(array($email));
		$result = $stmt->fetchAll();
		if(empty($result)){
			$error['not_found'] = 'records not found';
			$_SESSION['error'] = $error;
			header('location: ../login.php');
		}else{
			if (password_verify($password, $result[0]["password"])) {
				$user = new User($result[0]["id"], $result[0]["name"], $result[0]["email"]);
				$_SESSION['user'] = base64_encode(serialize($user));
		    	header('location: ../home.php');
			} else {
			    $error['not_match'] = 'password does not match.';
			    $_SESSION['error'] = $error;
			    header('location: ../login.php');
			}
		}

	}else{
		$_SESSION['error'] = $error;
		header('location: ../login.php');
	}

	

	
}


//register function
function register($data, $db){
	$error = [];
	
	if(!validate::isString($data["name"], 5)){
		$error["name"] = "name must contain a minimum of 5 chars";
	}

	if(!validate::isInt($data["secure_pin"],8)){
		$error["secure_pin"] = "Secure pin must be numbers only,and not less than 8 chars";
	}

	if(!validate::isEmail($data["email"])){
		$error["email"] = "invalid email entered";
	}

	if(!validate::isValidPassword($data["password"])){
		$error["password"] = "invalid password entered";
	}
	
	if(empty($error)){
		$email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
		$password = filter_var($data["password"] , FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$secure_pin = filter_var($data["secure_pin"] , FILTER_SANITIZE_NUMBER_INT);
		$name = filter_var($data["name"] , FILTER_SANITIZE_STRING);

		$hash_password = password_hash($password, PASSWORD_BCRYPT, array('cost'=>10));

		$query = "INSERT INTO `cloudcontact`.`users` (`name`, `email`, `secure_pin`, `password`) VALUES (?, ?, ?, ?);";
		$stmt = $db->prepare($query);
		$res = $stmt->execute(array($name, $email, $secure_pin, $hash_password));
		if($res){
			$error['success'] = "user registration successful: login to continue";
			$_SESSION['error'] = $error;
			header('location: ../login.php');
		}else{
			$error["email_used"] = "Email registered already!";
			$_SESSION['error'] = $error;
			header('location: ../register.php');
		}

	}else{
		$_SESSION['error'] = $error;
		header('location: ../register.php');
	}	
}

function add_contact($data, $db){
	$error = [];
	$old = [];
	var_dump($data);
	if(!validate::isString($data["name"], 5)){
		$error["name"] = "name must contain a minimum of 5 chars";
	}

	if(!validate::isEmail($data["email"])){
		$error["email"] = "invalid email entered";
	}

	if(!validate::isPhone($data["work_phone"])){
		$error["work_phone"] = "Phone number must be numbers only,and within 10 - 14 chars";
	}


	if(!validate::isPhone($data["mobile_phone"])){
		$error["mobile_phone"] = "Phone number must be numbers only,and within 10 - 14 chars";
	}


	
	if(empty($error)){

		$email = filter_var($data["email"], FILTER_SANITIZE_EMAIL);
		$mobile_phone = filter_var($data["mobile_phone"] , FILTER_SANITIZE_NUMBER_INT);
		$work_phone = filter_var($data["work_phone"] , FILTER_SANITIZE_NUMBER_INT);
		$name = filter_var($data["name"] , FILTER_SANITIZE_STRING);
		$id = filter_var($data["uniqid"] , FILTER_SANITIZE_NUMBER_INT);
		$query = "INSERT INTO `cloudcontact`.`contacts` (`name`, `email`, `mobile_phone`, `work_phone`, `user_id`) VALUES (?, ?, ?, ?, ?);";
		$stmt = $db->prepare($query);
		$res = $stmt->execute(array($name, $email, $mobile_phone, $work_phone, $id));
		if($res){
			$error['success'] = "new contact added successfully.";
			$_SESSION['error'] = $error;
			header('location: ../add-contact.php');
		}else{
			$error["msg"] = "Failed to add new contact, try again.";
			$_SESSION['error'] = $error;
			header('location: ../add-contact.php');
		}

	}else{
		$_SESSION['error'] = $error;
		$_SESSION['data'] = $data;
		header('location: ../add-contact.php');
	}	
}


?>