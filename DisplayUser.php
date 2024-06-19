<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>
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
            border: 3px solid #000;
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
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: blue;
        }
        a:hover {
            color: red;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 2px 0;
            cursor: pointer;
        }
        .delete-btn:hover {
            background-color: #c62828;
        }
    </style>
</head>
<body>
    <h2><center>User</center> </h2>
    <table>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Gender</th>
            <th>Mobile</th>
            <th>BOD</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php
        require 'connection.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user_id'])) {
            $userId = $_POST['delete_user_id'];
            // Delete user from the database
            $deleteQuery = "DELETE FROM `user` WHERE `user_id` = $userId";
            $result = mysqli_query($con, $deleteQuery);
            if ($result) {
                echo "<script>alert('User deleted successfully.');</script>";
            } else {
                echo "<script>alert('Failed to delete user.');</script>";
            }
        }

        $query = "SELECT * FROM `user`";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>" . $row["first_name"] . "</td>";
            echo "<td>" . $row["last_name"] . "</td>";
            echo "<td>" . $row["email"] . "</td>";
            echo "<td>" . $row["gender"] . "</td>";
            echo "<td>" . $row["mobile"] . "</td>";
            echo "<td>" . $row["bod"] . "</td>";
            echo "<td>" . $row["address"] . "</td>";
            echo "<td><button class='delete-btn' onclick='confirmDelete(" . $row["user_id"] . ")'>Delete</button></td>";
            echo "</tr>";
        }
        mysqli_close($con);
        ?>
    </table>
    <a href="HomePage.php">Back</a>

    <script>
        function confirmDelete(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            location.reload(); // Refresh the page after successful deletion
                        } else {
                            alert('Failed to delete user.');
                        }
                    }
                };
                xhr.open('POST', 'DisplayUser.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('delete_user_id=' + userId);
            }
        }
    </script>
</body>
</html>
