<?php
// Define the escape_input function here
function escape_input($con, $input) {
    return mysqli_real_escape_string($con, $input);
}

// Include the database connection file
require 'connection.php';

// Check if the form is submitted for adding a gym
if(isset($_POST['sb'])) {
    // Retrieve form data and escape input
    $name = escape_input($con, $_POST['name']);
    $location = escape_input($con, $_POST['location']);

    // Insert data into the gym table
    $query = "INSERT INTO gym (name, location) VALUES ('$name', '$location')";
    $result = mysqli_query($con, $query);

    // Check if the query was successful
    if($result) {
        echo "Gym added successfully.";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Add your custom styles here -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        header a {
            color: #fff;
            text-decoration: none;
            margin: 0 5px;
        }
        header a:hover {
            color: #ccc;
        }
        main {
            padding: 20px;
            background-color: #fff;
            margin: 20px auto;
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            margin-top: 0;
        }
        p {
            margin-bottom: 20px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        input {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
        }
        input[type="submit"], input[type="reset"] {
            width: auto;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
            padding: 10px 30px;
        }
        input[type="submit"]:hover, input[type="reset"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<main>
        <h1>Manage Gym</h1>
        <form method="post">
            <p>Enter Gym Name: <input type="text" name="name" required ></p>
            <p>Enter Gym Location: <input type="text" name="location" required></p>
            <p><input type="submit" name="sb" value="Add Gym"><input type="reset"></p>
        </form>

        <h2>Edit Gym</h2>
        <form method="post">
            <label for="gym_id">Choose the Gym:</label>
            <select name="gym_id">
                <?php
                require 'connection.php';
                $query = "SELECT gym_id, name FROM gym";
                $result = mysqli_query($con, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['gym_id']."'>".$row['name']."</option>"; 
                }
                ?>
            </select><br>
            <p>Gym Name: <input type="text" name="name"></p>
            <p>Location: <input type="text" name="location"></p>
            <input type="submit" value="Update" name="update">
        </form>

        <?php
        if(isset($_POST['update'])){
            $gym_id = $_POST['gym_id'];
            $name = escape_input($con, $_POST['name']);
            $location = escape_input($con, $_POST['location']);

            $query = "UPDATE gym SET ";
            $update_fields = [];
            if (!empty($name)) $update_fields[] = "name = '$name'";
            if (!empty($location)) $update_fields[] = "location = '$location'";
            $query .= implode(", ", $update_fields);
            $query .= " WHERE gym_id = $gym_id";
            
            $res = mysqli_query($con, $query);
            if ($res) {
                echo "Gym $gym_id has been updated successfully.";
            } else {
                echo "Error in the query: " . mysqli_error($con);
            }
        }

        if(isset($_POST["delete"])){
            $gym_id = $_POST['gym_id'];
            require 'connection.php';
            $query = "DELETE FROM `gym` WHERE `gym_id` = '$gym_id'";
        
            $res = mysqli_query($con, $query);
            if($res) {
                echo "Gym $gym_id has been deleted successfully.";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }

        echo "<h2>Gym List</h2>";
        echo "<table border='1' cellpadding='5'>
            <tr>
                <th>Gym ID</th>
                <th>Name</th>
                <th>Location</th>
            </tr>";

        $query = "SELECT * FROM `gym`";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                <td>" .$row["gym_id"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["location"] . "</td>
            </tr>";
        }

        echo "</table>";
        
        mysqli_close($con);
        ?>

        <h2>Delete a Gym</h2>
        <form action="" method="POST">
            <label for="delete_gym_id">Choose the Gym to Delete:</label>
            <select name="gym_id" id="delete_gym_id">
                <?php
                require 'connection.php';
                $query = "SELECT gym_id, name FROM gym";
                $result = mysqli_query($con, $query);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['gym_id']."'>".$row['name']."</option>"; 
                }
                ?>
            </select><br><br>
            <input type="submit" name="delete" value="Delete Gym">
        </form>

        <a href="HomePage.php">Back</a>
    </main>
    <footer>
        &copy; <?php echo date("Y"); ?> Gym Website. All Rights Reserved.
    </footer>
    
</body>
</html>
