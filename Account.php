<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            text-align: center;
        }
        h1 {
            margin-top: 20px;
        }
        form {
            margin-top: 20px;
            display: inline-block;
            text-align: left;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        a {
            display: block;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Account Settings</h1>
    <?php
    session_start();
    require 'connection.php';

    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit();
    }

    $userId = $_SESSION['user_id'];

    $query = "SELECT * FROM user WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $newMobile = $_POST['mobile'];
        $newEmail = $_POST['email'];
        $newPassword = $_POST['password'];

        $updateQuery = "UPDATE user SET mobile = ?, email = ?, password = ? WHERE user_id = ?";
        $stmt = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($stmt, "sssi", $newMobile, $newEmail, $newPassword, $userId);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Account settings updated successfully!</p>";
            $_SESSION['mobile'] = $newMobile;
            $_SESSION['email'] = $newEmail;
        } else {
            echo "<p>Error updating account settings: " . mysqli_error($con) . "</p>";
        }

        mysqli_stmt_close($stmt);
        mysqli_close($con);
    }
    ?>
    <p>Welcome, <?php echo $user['first_name']; ?>!</p>
    <form action="" method="POST">
        <label for="mobile">Mobile:</label>
        <input type="text" id="mobile" name="mobile" value="<?php echo $user['mobile']; ?>"><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>"><br>
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password"><br>
        <input type="submit" value="Save Changes">
    </form>
    <a href="HomePage.php">Back</a>
</body>
</html>
