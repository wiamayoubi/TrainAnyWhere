<?php
session_start();
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // User login
    $sql_user = "SELECT * FROM user WHERE username=? AND password=?";
    $stmt_user = mysqli_prepare($con, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "ss", $username, $password);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);

    // Trainer login
    $sql_trainer = "SELECT * FROM trainer WHERE username=? AND password=?";
    $stmt_trainer = mysqli_prepare($con, $sql_trainer);
    mysqli_stmt_bind_param($stmt_trainer, "ss", $username, $password);
    mysqli_stmt_execute($stmt_trainer);
    $result_trainer = mysqli_stmt_get_result($stmt_trainer);

    // Admin login
    $sql_admin = "SELECT * FROM admin WHERE username=? AND password=?";
    $stmt_admin = mysqli_prepare($con, $sql_admin);
    mysqli_stmt_bind_param($stmt_admin, "ss", $username, $password);
    mysqli_stmt_execute($stmt_admin);
    $result_admin = mysqli_stmt_get_result($stmt_admin);

    if (mysqli_num_rows($result_user) > 0) {
        $row = mysqli_fetch_assoc($result_user);
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_type'] = 'user';
        header("Location: User/HomePage.php");
        exit();
    } elseif (mysqli_num_rows($result_trainer) > 0) {
        $row = mysqli_fetch_assoc($result_trainer);
        $_SESSION['trainer_id'] = $row['trainer_id'];
        $_SESSION['trainer_name'] = $row['username']; // Assuming you want to store the username as trainer_name
        $_SESSION['user_type'] = 'trainer';
        header("Location: Trainer/HomePage.php");
        exit();
    } elseif (mysqli_num_rows($result_admin) > 0) {
        $row = mysqli_fetch_assoc($result_admin);
        $_SESSION['user_id'] = $row['admin_id'];
        $_SESSION['user_type'] = 'admin';
        header("Location: Admin/HomePage.php");
        exit();
    } else {
        $error = "Invalid username or password. Please try again.";
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/carousel-1.jpg');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }
        main {
            margin: 20px auto;
            width: 80%;
            text-align: center;
        }
        img {
            display: block;
            margin: 0 auto;
            width: 150px;
            height: auto;
        }
        h1 {
            margin-top: 20px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            width: calc(100% - 20px);
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        input[type="submit"] {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 3px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #555;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        a {
            text-decoration: none;
            color: #333;
        }
    </style>
</head>
<body>
    <header>
    </header>
    <main>
        <img src="Images/Logo.png" alt="Logo">
        <h1>Login</h1>
        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
        <div class="form-container">
            <form action="Login.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="submit" value="Login">
            </form>
            <label for="signup">Don't have an account?</label> <a href="SignUp.php">SignUp</a>
            <br><br>
            <a href="Home.html">Back</a>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
