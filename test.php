<?php
session_start();
require 'connection.php';

// Fetch admin inquiries for the logged-in admin user
$admin_id = $_SESSION['user_id'];
$query = "SELECT ai.inquiry_id, CONCAT(u.first_name, ' ', u.last_name) AS user_name, ai.message 
          FROM admin_inquiries ai 
          INNER JOIN user u ON ai.user_id = u.user_id";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Handle delete request
if (isset($_POST['delete'])) {
    $inquiry_id = $_POST['inquiry_id'];
    $delete_query = "DELETE FROM admin_inquiries WHERE inquiry_id = ?";
    $delete_stmt = mysqli_prepare($con, $delete_query);
    mysqli_stmt_bind_param($delete_stmt, "i", $inquiry_id);
    mysqli_stmt_execute($delete_stmt);
    
    // Refresh the page to reflect changes
    header("Location: Inquiry.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Inquiries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        h1 {
            margin-top: 0;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        form {
            display: inline;
        }
        button {
            background-color: #ff4d4d;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        button:hover {
            background-color: #ff1a1a;
        }
    </style>
</head>
<body>  
    <h1>Admin Inquiries</h1>
    <?php if (mysqli_num_rows($result) > 0) : ?>
    <table border="1">
        <tr>
            <th>Inquiry ID</th>
            <th>User</th>
            <th>Message</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['inquiry_id']); ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['message']); ?></td>
                <td>
                    <form action="Inquiry.php" method="post">
                        <input type="hidden" name="inquiry_id" value="<?php echo $row['inquiry_id']; ?>">
                        <button type="submit" name="delete">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <?php else : ?>
    <p>No inquiries found.</p>
    <?php endif; ?>
    <a href="HomePage.php">Back</a>
</body>
</html>
