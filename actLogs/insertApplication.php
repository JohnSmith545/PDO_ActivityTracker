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

	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="address">Address</label>
			<input type="text" name="address"></p>
		<p>
			<label for="address">First Name</label>
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="address">Last Name</label>
			<input type="text" name="last_name">
		<p>
			<label for="email">Email</label>
			<input type="text" name="email"></p>
		<p>
			<label for="gender">Gender</label>
			<input type="text" name="gender">
		</p>
		<p>
			<label for="state">State</label>
			<input type="text" name="state"></p>
		<p>
			<label for="nationality">Nationality</label>
			<input type="text" name="nationality">
		<p>
			<label for="specialty">Specialty</label>
			<input type="text" name="specialty">
			<input type="submit" name="insertNewApplicationBtn" value="Create">
		</p>
	</form>

	<div class="tableClass">
		<table style="width: 100%;" cellpadding="20">
			<tr>
				<th>Address</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>Gender</th>
				<th>State</th>
				<th>Nationality</th>
				<th>Sepcialty</th>
				<th>Date Added</th>
				<th>Added By</th>
				<th>Last Updated</th>
				<th>Last Updated By</th>
				<th>Action</th>
			</tr>
			<?php if (!isset($_GET['searchBtn'])) { ?>
				<?php $getAllApplications = getAllApplications($pdo); ?>
				<?php foreach ($getAllApplications as $row) { ?>
				<tr>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['first_name']; ?></td>
					<td><?php echo $row['last_name']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['state']; ?></td>
					<td><?php echo $row['nationality']; ?></td>
					<td><?php echo $row['specialty']; ?></td>
					<td><?php echo $row['date_added']; ?></td>
					<td><?php echo $row['added_by']; ?></td>
					<td><?php echo $row['last_updated']; ?></td>
					<td><?php echo $row['last_updated_by']; ?></td>
					<td>
						<a href="updateApplication.php?application_id=<?php echo $row['application_id']; ?>">Update</a>
					</td>
				</tr>
				<?php } ?>
			<?php } else { ?>
				<?php $getAllApplicationsBySearch = getAllApplicationsBySearch($pdo, $_GET['searchQuery']); ?>
				<?php foreach ($getAllApplicationsBySearch as $row) { ?>
				<tr>
					<td><?php echo $row['address']; ?></td>
					<td><?php echo $row['first_name']; ?></td>
					<td><?php echo $row['last_name']; ?></td>
					<td><?php echo $row['email']; ?></td>
					<td><?php echo $row['gender']; ?></td>
					<td><?php echo $row['state']; ?></td>
					<td><?php echo $row['nationality']; ?></td>
					<td><?php echo $row['specialty']; ?></td>
					<td><?php echo $row['date_added']; ?></td>
					<td><?php echo $row['added_by']; ?></td>
					<td><?php echo $row['last_updated']; ?></td>
					<td><?php echo $row['last_updated_by']; ?></td>
					<td>
						<a href="updateApplication.php?application_id=<?php echo $row['application_id']; ?>">Update</a>
					</td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>
	</div>

</body>
</html>