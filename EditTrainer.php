<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 50px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
            margin-bottom: 10px;
            color: #555;
        }
        select, input[type="text"], input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .link-container {
            text-align: center;
            margin-top: 20px;
        }
        a {
            text-decoration: none;
            color: #007bff;
            margin: 0 10px;
        }
        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Trainer</h2>
        <?php
        require 'connection.php';
        $query = "SELECT trainer_id, name, email, mobile FROM trainer";
        $result = mysqli_query($con, $query);
        ?>

        <form method="post" action="">
            <div class="mb-3">
                <label for="trainer_id" class="form-label">Choose the Trainer:</label>
                <select name="trainer_id" id="trainer_id" class="form-select" required>
                    <?php
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['trainer_id']."'>".$row['name']."</option>"; 
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" name="email" id="email" class="form-control">
            </div>

            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile:</label>
                <input type="number" name="mobile" id="mobile" class="form-control">
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="text" name="password" id="password" class="form-control">
            </div>

            <input type="submit" value="Update" name="update" class="btn btn-primary">
        </form>

        <?php
        if(isset($_POST['update'])){
            $trainer_id = $_POST['trainer_id'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $mobile = $_POST['mobile'];
            $password = $_POST['password'];

            require 'connection.php';

            $query = "UPDATE trainer SET ";
            $update_fields = [];
            if (!empty($name)) $update_fields[] = "name = '$name'";
            if (!empty($email)) $update_fields[] = "email = '$email'";
            if (!empty($mobile)) $update_fields[] = "mobile = '$mobile'";
            if (!empty($password)) $update_fields[] = "password = '$password'";
            $query .= implode(", ", $update_fields);
            $query .= " WHERE trainer_id = $trainer_id";

            $res = mysqli_query($con, $query);
            mysqli_close($con);
            if ($res) {
                echo "<div class='alert alert-success' role='alert'>Trainer $trainer_id is updated</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Error in the query</div>";
            }
        }
        ?>

        <div class="link-container">
            <a href="DisplayTrainer.php" class="btn btn-secondary">Display All The Trainers</a>
            <a href="HomePage.php" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-qgMFSowS0IsFZnLgkW3CDIpX/Zb/yVmN5MRGq5InfiKx0YVZBlV1LVQxvZdEhZSm" crossorigin="anonymous"></script>
</body>
</html>
