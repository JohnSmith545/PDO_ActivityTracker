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
    <div class="searchForm">
        <form action="index.php" method="GET">
            <p>
                <input type="text" name="searchQuery" placeholder="Search here">
                <input type="submit" name="searchBtn" value="Search">
                <h3><a href="index.php">Search Again</a></h3>    
            </p>
        </form>
    </div>

    <?php  
    // Display status messages if any
    if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
        if ($_SESSION['status'] == "200") {
            echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
        } else {
            echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";    
        }
        unset($_SESSION['message']);
        unset($_SESSION['status']);
    }
    ?>

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
                <th>Specialty</th>
                <th>Date Added</th>
                <th>Added By</th>
                <th>Last Updated</th>
                <th>Last Updated By</th>
                <th>Action</th>
            </tr>
            <?php 
            if (!isset($_GET['searchBtn'])) { 
                $getAllApplications = getAllApplications($pdo); 
                foreach ($getAllApplications as $row) { ?>
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
                            <a href="deleteApplication.php?application_id=<?php echo $row['application_id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php } 
            } else { 
                $searchQuery = trim($_GET['searchQuery']);
                $getAllApplicationsBySearch = getAllApplicationsBySearch($pdo, $searchQuery); 

                if (!empty($getAllApplicationsBySearch)) {
                    foreach ($getAllApplicationsBySearch as $row) {
                        logSearchActivity(
                            $pdo,
                            'SEARCH',                  // Operation
                            $row['application_id'],    // Application ID
                            $row['address'],           // Address
                            $row['first_name'],        // First Name
                            $row['last_name'],         // Last Name
                            $_SESSION['username'],     // Username
                            $searchQuery               // Search keyword
                        );
                        ?>
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
                                <a href="deleteApplication.php?application_id=<?php echo $row['application_id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } 
                } else {
                    echo "<tr><td colspan='13'>No results found for your search query: {$searchQuery}</td></tr>";
                }
            } ?>
        </table>
    </div>
</body>
</html>
