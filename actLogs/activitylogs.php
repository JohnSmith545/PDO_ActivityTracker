<?php
require_once 'core/models.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Logs</title>
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="tableClass">
        <table style="width: 100%;" cellpadding="20">
            <tr>
                <th>Operation</th>
                <th>Application ID</th>
                <th>Address</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Search Keyword</th>
                <th>Date</th>
            </tr>
            <?php
            $activityLogs = getAllActivityLogs($pdo);
            foreach ($activityLogs as $log) { ?>
                <tr>
                    <td><?php echo $log['operation']; ?></td>
                    <td><?php echo $log['application_id']; ?></td>
                    <td><?php echo $log['address']; ?></td>
                    <td><?php echo $log['first_name']; ?></td>
                    <td><?php echo $log['last_name']; ?></td>
                    <td><?php echo $log['username']; ?></td>
                    <td><?php echo $log['search_keyword']; ?></td>
                    <td><?php echo $log['date_added']; ?></td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
