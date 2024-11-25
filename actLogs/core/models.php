<?php  

require_once 'dbConfig.php';

function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;

}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {

		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}

		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}

	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getAllApplications($pdo) {
	$sql = "SELECT * FROM applications";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getAllApplicationsBySearch($pdo, $search_query) {
	$sql = "SELECT * FROM applications WHERE 
			CONCAT(address,first_name,
				last_name,email,
				gender,state,
				nationality,
				date_added,added_by,
				last_updated,
				last_updated_by) 
			LIKE ?";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute(["%".$search_query."%"]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function getApplicationByID($pdo, $application_id) {
	$sql = "SELECT * FROM applications WHERE application_id = ?";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute([$application_id])) {
		return $stmt->fetch();
	}
}

function insertAnActivityLog($pdo, $operation, $application_id, $address, 
		$first_name, $last_name, $username) {

	$sql = "INSERT INTO activity_logs (operation, application_id, address, 
		first_name, last_name, username) VALUES(?,?,?,?,?,?)";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$operation, $application_id, $address, 
		$first_name, $last_name, $username]);

	if ($executeQuery) {
		return true;
	}

}

function getAllActivityLogs($pdo) {
	$sql = "SELECT * FROM activity_logs";
	$stmt = $pdo->prepare($sql);
	if ($stmt->execute()) {
		return $stmt->fetchAll();
	}
}

function insertApplication($pdo, $address, $first_name, $last_name, $email, $gender, $state, $nationality, $specialty, $added_by) {
	$response = array();
	$sql = "INSERT INTO applications (address, first_name, last_name, email, gender, state, nationality, specialty, added_by) VALUES(?,?,?,?,?,?,?,?,?)";
	$stmt = $pdo->prepare($sql);
	$insertApplication = $stmt->execute([$address, $first_name, $last_name, $email, $gender, $state, $nationality, $specialty, $added_by]);

	if ($insertApplication) {
		$findInsertedItemSQL = "SELECT * FROM applications ORDER BY date_added DESC LIMIT 1";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute();
		$getApplicationID = $stmtfindInsertedItemSQL->fetch();

		$insertAnActivityLog = insertAnActivityLog($pdo, "INSERT", $getApplicationID['application_id'], 
			$getApplicationID['address'], $getApplicationID['first_name'], 
			$getApplicationID['last_name'], $_SESSION['username']);

		if ($insertAnActivityLog) {
			$response = array(
				"status" =>"200",
				"message"=>"Application addedd successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
		
	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"Insertion of data failed!"
		);

	}

	return $response;
}

function updateApplication($pdo, $address, $first_name, $last_name, $email, $gender, $state, $nationality, $specialty, 
	$last_updated, $last_updated_by, $application_id) {

	$response = array();
	$sql = "UPDATE applications
			SET address = ?,
				first_name = ?,
				last_name = ?, 
				email = ?,
				gender = ?,
				state = ?,
				nationality = ?,
				specialty = ?,
				last_updated = ?, 
				last_updated_by = ? 
			WHERE application_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$updateApplication = $stmt->execute([$address, $first_name, $last_name, $email, $gender, $state, $nationality, $specialty, 
	$last_updated, $last_updated_by, $application_id]);

	if ($updateApplication) {

		$findInsertedItemSQL = "SELECT * FROM applications WHERE application_id = ?";
		$stmtfindInsertedItemSQL = $pdo->prepare($findInsertedItemSQL);
		$stmtfindInsertedItemSQL->execute([$application_id]);
		$getApplicationID = $stmtfindInsertedItemSQL->fetch(); 

		$insertAnActivityLog = insertAnActivityLog($pdo, "UPDATE", $getApplicationID['application_id'], 
			$getApplicationID['address'], $getApplicationID['first_name'], 
			$getApplicationID['last_name'], $_SESSION['username']);

		if ($insertAnActivityLog) {

			$response = array(
				"status" =>"200",
				"message"=>"Updated the Application successfully!"
			);
		}

		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}

	}

	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error has occured with the query!"
		);
	}

	return $response;

}


function deleteApplication($pdo, $application_id) {
	$response = array();
	$sql = "SELECT * FROM applications WHERE application_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$application_id]);
	$getApplicationByID = $stmt->fetch();

	$insertAnActivityLog = insertAnActivityLog($pdo, "DELETE", $getApplicationByID['application_id'], 
		$getApplicationByID['address'], $getApplicationByID['first_name'], 
		$getApplicationByID['last_name'], $_SESSION['username']);

	if ($insertAnActivityLog) {
		$deleteSql = "DELETE FROM applications WHERE application_id = ?";
		$deleteStmt = $pdo->prepare($deleteSql);
		$deleteQuery = $deleteStmt->execute([$application_id]);

		if ($deleteQuery) {
			$response = array(
				"status" =>"200",
				"message"=>"Deleted the Application successfully!"
			);
		}
		else {
			$response = array(
				"status" =>"400",
				"message"=>"Insertion of activity log failed!"
			);
		}
	}
	else {
		$response = array(
			"status" =>"400",
			"message"=>"An error has occured with the query!"
		);
	}

	return $response;
}

function logSearchActivity($pdo, $operation, $application_id, $address, $first_name, $last_name, $username, $search_keyword) {
    $sql = "INSERT INTO activity_logs (operation, application_id, address, first_name, last_name, username, search_keyword) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$operation, $application_id, $address, $first_name, $last_name, $username, $search_keyword]);
}

// $getAllApplicationsBySearch = getAllApplicationsBySearch($pdo, "Dasma");
// echo "<pre>";
// print_r($getAllApplicationsBySearch);
// echo "<pre>";



?>