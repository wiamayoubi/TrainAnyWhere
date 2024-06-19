<?php
session_start();

require 'connection.php';

if(isset($_POST["sb"])){
    $name = isset($_POST['name']) ? mysqli_real_escape_string($con, $_POST['name']) : '';
    $description = isset($_POST['description']) ? mysqli_real_escape_string($con, $_POST['description']) : '';
    $cost = isset($_POST['cost']) ? mysqli_real_escape_string($con, $_POST['cost']) : '';
    $trainer_id = mysqli_real_escape_string($con, $_SESSION['trainer_id']);

    $query = "INSERT INTO `training`(`trainer_id`, `name`, `description`, `cost`) VALUES ('$trainer_id', '$name', '$description', '$cost')";

    if(mysqli_query($con, $query)){
        echo "The Training $name has been added successfully.";
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

if(isset($_POST['edit'])) {
    $training_id = mysqli_real_escape_string($con, $_POST['training_id']);
    $name = isset($_POST['edit_name']) ? mysqli_real_escape_string($con, $_POST['edit_name']) : '';
    $description = isset($_POST['edit_description']) ? mysqli_real_escape_string($con, $_POST['edit_description']) : '';
    $cost = isset($_POST['edit_cost']) ? mysqli_real_escape_string($con, $_POST['edit_cost']) : '';

    $update_query = "UPDATE training SET name='$name', description='$description', cost='$cost' WHERE training_id='$training_id'";
    if(mysqli_query($con, $update_query)){
        echo "Training updated successfully.";
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error updating training: " . mysqli_error($con);
    }
}

if(isset($_POST['delete'])) {
    $training_id = mysqli_real_escape_string($con, $_POST['training_id']);

    $delete_query = "DELETE FROM training WHERE training_id='$training_id'";
    if(mysqli_query($con, $delete_query)){
        echo "Training deleted successfully.";
        echo "<meta http-equiv='refresh' content='0'>";
    } else {
        echo "Error deleting training: " . mysqli_error($con);
    }
}

if (isset($_SESSION['trainer_id'])) {
    $trainer_id = $_SESSION['trainer_id'];
    $query = "SELECT * FROM training WHERE trainer_id='$trainer_id'";
    $result = mysqli_query($con, $query);

    echo "<h1><center>Manage Training</center></h1>";
    echo "<table border='1'>";
    echo "<tr>
    <th>Name</th>
    <th>Description</th>
    <th>Cost</th>
    <th>Action</th>
    </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
        <td>{$row['name']}</td>
        <td>{$row['description']}</td>
        <td>{$row['cost']}</td>
        <td>
            <button onclick='editCost({$row['training_id']}, \"{$row['name']}\", \"{$row['description']}\", \"{$row['cost']}\")'>Edit</button> | 
            <form method='post' style='display:inline;'>
                <input type='hidden' name='training_id' value='{$row['training_id']}'>
                <button type='submit' name='delete'>Delete</button>
            </form>
        </td></tr>";
    }
    
    echo "</table>";

    echo "<div id='edit_training_div' style='display:none;'>";
    echo "<h2>Edit Training</h2>";
    echo "<form method='post'>";
    echo "<input type='hidden' id='edit_training_id' name='training_id'>";
    echo "Name: <input type='text' id='edit_name' name='edit_name'><br>";
    echo "Description: <input type='text' id='edit_description' name='edit_description'><br>";
    echo "Cost: <input type='text' id='edit_cost' name='edit_cost'><br>";
    echo "<input type='submit' name='edit' value='Save'>";
    echo "</form>";
    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Training</title>
    <script>
    function editCost(training_id, name, description, cost) {
        var editDiv = document.getElementById('edit_training_div');
        var nameInput = document.getElementById('edit_name');
        var descriptionInput = document.getElementById('edit_description');
        var costInput = document.getElementById('edit_cost');
        var editTrainingIdInput = document.getElementById('edit_training_id');

        nameInput.value = name;
        descriptionInput.value = description;
        costInput.value = cost;
        editTrainingIdInput.value = training_id; 

        editDiv.style.display = 'block'; 
    }
</script>

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
            width: 80%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            margin-top: 0;
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
        #edit_training_div {
            margin-top: 20px;
        }
        #edit_training_div input[type="text"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-sizing: border-box;
        }
        #edit_training_div input[type="submit"] {
            padding: 8px 16px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #edit_training_div input[type="submit"]:hover {
            background-color: #555;
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
    </style>
</head>
<body>
    <main>
        <h1><center>Insert new Training</center></h1>

        <form method="post">
            <p>Enter Training Name: <input type="text" name="name" required></p>
            <p>Enter Training Description: <input type="text" name="description" required></p>
            <p>Enter Training Cost: <input type="text" name="cost" required></p>
            <?php
            if (isset($_SESSION['trainer_id'])) {
                $trainer_id = $_SESSION['trainer_id'];
                $query = "SELECT name FROM trainer WHERE trainer_id='$trainer_id'";
                $result = mysqli_query($con, $query);
                $trainer_name = mysqli_fetch_assoc($result)['name'];
                echo "<input type='hidden' name='trainer_id' value='$trainer_id'>";
                echo "<p>Trainer: $trainer_name</p>";
            }
            ?>
            <p><input type="submit" name="sb" value="Add Training"></p>
        </form>
        <a href="HomePage.php">Back</a>
    </main>
</body>
</html>
