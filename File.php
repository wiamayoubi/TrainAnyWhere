<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            color: red;
        }
    </style>
</head>
<body>
    <h2>Trainer Applications</h2>
    <table>
        <tr>
            <th>Application ID</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Certificate File</th>
            <th>Resume File</th>
            <th>Actions</th>
        </tr>
        <?php
        require_once 'connection.php';

        $query = "SELECT * FROM trainer_applications";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>{$row['application_id']}</td>";
            echo "<td>{$row['full_name']}</td>";
            echo "<td>{$row['email']}</td>";
            echo "<td>{$row['mobile']}</td>";
            echo "<td><a href='uploads/{$row['certificate_file']}' target='_blank'>Download</a></td>";
            echo "<td><a href='uploads/{$row['resume_file']}' target='_blank'>Download</a></td>";
            echo "<td>";
            echo "<a href='accept_application.php?application_id={$row['application_id']}'>Accept</a> | ";
            echo "<a href='reject_application.php?application_id={$row['application_id']}'>Reject</a>";
            echo "</td>";
            echo "</tr>";
        }
        mysqli_close($con);
        ?>
    </table>
    <a href="HomePage.php">Home</a>
</body>
</html>
