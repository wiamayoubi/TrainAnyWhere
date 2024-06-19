<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert New Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            width: 60%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            margin-top: 0;
            text-align: center;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        p {
            margin-bottom: 15px;
        }
        input[type="text"],
        input[type="number"],
        input[type="submit"],
        input[type="reset"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 10px;
        }
        input[type="submit"],
        input[type="reset"] {
            width: auto;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 20px;
        }
        input[type="submit"]:hover,
        input[type="reset"]:hover {
            background-color: #555;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #333;
            text-decoration: none;
        }
        a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <main>
        <h1>Insert New Trainer</h1>
        <form method="post">
            <p>Enter Trainer Name: <input type="text" name="name" required></p>
            <p>Enter Trainer Email: <input type="text" name="email" required></p>
            <p>Enter Trainer Mobile: <input type="number" name="mobile" required></p>
            <p>Create the Username: <input type="text" name="username" required></p>
            <p>Create the Password: <input type="text" name="password" required></p>
            <p><input type="submit" name="sb" value="Submit"><input type="reset" value="Reset"></p>
        </form>

        <?php
        if(isset($_POST["sb"])){
            require 'connection.php';

            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $username = $_POST['username'];
            $password = $_POST['password'];

            $query = "INSERT INTO `trainer`(`name`, `email`, `mobile`, `username`, `password`) VALUES ('$name','$email','$mobile','$username','$password')";

            if (mysqli_query($con, $query)) {
                echo "The Trainer $name has been added successfully.";
            } else {
                echo "The Trainer $name was not added. Please check for duplicate entries or try again.";
            }

            mysqli_close($con);
        }
        ?>

        <a href="HomePage.php">Back</a>
    </main>
</body>
</html>
