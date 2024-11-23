<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php';
 
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
	<style>
		body {
			font-family: "Arial";
		}
		input {
			font-size: 1.5em;
			height: 50px;
			width: 200px;
		}
		table, th, td {
			border:1px solid black;
		}
	</style>
</head>
<body>
	<h1>Are you sure you want to delete this Application?</h1>
	<?php $getApplicationByID = getApplicationByID($pdo, $_GET['application_id']); ?>
	<div class="container" style="border-style: solid; border-color: red; background-color: #ffcbd1;height: 500px;">
		<h2>Address: <?php echo $getApplicationByID['address']; ?></h2>
		<h2>First Name: <?php echo $getApplicationByID['first_name']; ?></h2>
		<h2>Last Name: <?php echo $getApplicationByID['last_name']; ?></h2>
		<h2>Email: <?php echo $getApplicationByID['email']; ?></h2>
		<h2>Gender: <?php echo $getApplicationByID['gender']; ?></h2>
		<h2>State: <?php echo $getApplicationByID['state']; ?></h2>
		<h2>Nationality: <?php echo $getApplicationByID['nationality']; ?></h2>
		<h2>Specialty: <?php echo $getApplicationByID['specialty']; ?></h2>

		<div class="deleteBtn" style="float: right; margin-right: 10px;">
			<form action="core/handleForms.php?application_id=<?php echo $_GET['application_id']; ?>" method="POST">
				<input type="submit" name="deleteApplicationBtn" value="Delete" style="background-color: #f69697; border-style: solid;">
			</form>			
		</div>	

	</div>
</body>
</html>
