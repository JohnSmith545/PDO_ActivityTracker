<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if (!isset($_SESSION['username'])) {
	header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles/styles.css">
</head>
<body>
	<?php include 'navbar.php'; ?>

	<?php $getApplicationByID = getApplicationByID($pdo, $_GET['application_id']); ?>
	<form action="core/handleForms.php?application_id=<?php echo $_GET['application_id']; ?>" method="POST">
		<p>
			<label for="address">Address</label>
			<input type="text" name="address" value="<?php echo $getApplicationByID['address']; ?>"></p>
		<p>
			<label for="address">First Name</label>
			<input type="text" name="first_name" value="<?php echo $getApplicationByID['first_name']; ?>">
		</p>
		<p>
			<label for="address">Last Name</label>
			<input type="text" name="last_name" value="<?php echo $getApplicationByID['last_name']; ?>">
		<p>
			<label for="email">Email</label>
			<input type="text" name="email" value="<?php echo $getApplicationByID['email']; ?>"></p>
		<p>
			<label for="gender">Gender</label>
			<input type="text" name="gender" value="<?php echo $getApplicationByID['gender']; ?>">
		<p>
			<label for="state">State</label>
			<input type="text" name="state" value="<?php echo $getApplicationByID['state']; ?>"></p>
		<p>
			<label for="nationality">Nationality</label>
			<input type="text" name="nationality" value="<?php echo $getApplicationByID['nationality']; ?>">
		<p>
			<label for="specialty">Specialty</label>
			<input type="text" name="specialty" value="<?php echo $getApplicationByID['specialty']; ?>"></p>
			<input type="submit" name="updateApplicationBtn" value="Update">
		</p>
	</form>
</body>
</html>