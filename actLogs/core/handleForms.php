<?php  
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);
	$confirm_password = trim($_POST['confirm_password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password) && !empty($confirm_password)) {

		if ($password == $confirm_password) {

			$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
			$_SESSION['message'] = $insertQuery['message'];

			if ($insertQuery['status'] == '200') {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../login.php");
			}

			else {
				$_SESSION['message'] = $insertQuery['message'];
				$_SESSION['status'] = $insertQuery['status'];
				header("Location: ../register.php");
			}

		}
		else {
			$_SESSION['message'] = "Please make sure both passwords are equal";
			$_SESSION['status'] = '400';
			header("Location: ../register.php");
		}

	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: ../index.php");
		}

		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}


if (isset($_POST['insertNewApplicationBtn'])) {
	$address = trim($_POST['address']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $nationality = trim($_POST['nationality']);
    $specialty = trim($_POST['specialty']);

	if (!empty($address) && !empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender) && !empty($state) && !empty($nationality) && !empty($specialty)) {
		$insertApplication = insertApplication($pdo, $address, $first_name, 
			$last_name, $email, $gender, $state, $nationality, $specialty, $_SESSION['username']);
		$_SESSION['status'] =  $insertApplication['status']; 
		$_SESSION['message'] =  $insertApplication['message']; 
		header("Location: ../index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../index.php");
	}

}

if (isset($_POST['updateApplicationBtn'])) {

	$address = $_POST['address'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = trim($_POST['email']);
    $gender = trim($_POST['gender']);
    $state = trim($_POST['state']);
    $nationality = trim($_POST['nationality']);
    $specialty = trim($_POST['specialty']);
	$date = date('Y-m-d H:i:s');

	if (!empty($address) && !empty($first_name) && !empty($last_name) && !empty($email) && !empty($gender) && !empty($state) && !empty($nationality) && !empty($specialty)) {

		$updateApplication = updateApplication($pdo, $address, $first_name, $last_name, $email, $gender, $state, $nationality, $specialty, 
			$date, $_SESSION['username'], $_GET['application_id']);

		$_SESSION['message'] = $updateApplication['message'];
		$_SESSION['status'] = $updateApplication['status'];
		header("Location: ../index.php");
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}

if (isset($_POST['deleteApplicationBtn'])) {
	$application_id = $_GET['application_id'];

	if (!empty($application_id)) {
		$deleteApplication = deleteApplication($pdo, $application_id);
		$_SESSION['message'] = $deleteApplication['message'];
		$_SESSION['status'] = $deleteApplication['status'];
		header("Location: ../index.php");
	}
}

if (isset($_GET['logoutUserBtn'])) {
	unset($_SESSION['username']);
	header("Location: ../login.php");
}

?>