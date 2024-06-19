<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id']; 
}

if (isset($_POST['reserve'])) {
    if (isset($user_id) && isset($_POST['training_id'])) {
       
        $check_query = "SELECT * FROM personaltrainingregistration WHERE user_id = '$user_id' AND training_id = '" . $_POST['training_id'] . "'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "You have already registered for this training session.";
        } else {
            $insert_query = "INSERT INTO personaltrainingregistration (user_id, training_id, status) VALUES ('$user_id', '" . $_POST['training_id'] . "', 'Pending')";

            if (mysqli_query($con, $insert_query)) {
                echo "Reservation successful.";
            } else {
                echo "Error: " . mysqli_error($con);
            }
        }
    } else {
        echo "Error: User ID or Training ID not set.";
    }
}

// Fetch both pending and approved personal training sessions
$query = "SELECT 
            pt.id,
            trainer.name AS trainer_name, 
            pt.training_name, 
            pt.training_description, 
            pt.cost, 
            pt.training_provided, 
            pt.time, 
            pt.day_of_week,
            ptr.status
          FROM 
            personaltrainingregistration ptr
          INNER JOIN 
            personaltraining pt ON ptr.training_id = pt.id
          INNER JOIN 
            trainer ON pt.trainer_id = trainer.trainer_id
          WHERE 
            ptr.user_id = '$user_id'";
$result = mysqli_query($con, $query);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Training</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
            text-align: center;
        }
        h1 {
            margin-top: 0;
        }
        table {
            margin: 0 auto;
            border-collapse: collapse;
            width: 80%;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #333;
            color: #fff;
        }
        input[type="text"] {
            width: 30%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            padding: 8px 20px;
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

    <input type="text" id="search" autocomplete="off" placeholder="Search...">
    <br><br>

    <table>
        <tr>
            <th>Trainer</th>
            <th>Training Name</th>
            <th>Training Description</th>
            <th>Cost</th>
            <th>Training Provided</th>
            <th>Time</th>
            <th>Day Of Week</th>
            <th>Action</th>
        </tr>
        <?php
    
        $query = "SELECT trainer.name AS trainer_name, personaltraining.id, personaltraining.training_name, personaltraining.training_description, personaltraining.cost, personaltraining.training_provided, personaltraining.time, personaltraining.day_of_week
                  FROM personaltraining
                  INNER JOIN trainer ON personaltraining.trainer_id = trainer.trainer_id";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_assoc($result)) {
           
            if (isset($user_id)) {
                $check_query = "SELECT * FROM personaltrainingregistration WHERE user_id = '$user_id' AND training_id = '" . $row["id"] . "'";
                $check_result = mysqli_query($con, $check_query);

                if (mysqli_num_rows($check_result) > 0) {
                    $reserve_button = "<button disabled>Reserved</button>";
                } else {
                    $reserve_button = "<button name='reserve' value='" . $row["id"] . "'>Reserve</button>";
                }
            } else {
                $reserve_button = "<button disabled>Login Required</button>";
            }

            echo "<tr>
                    <td>{$row['trainer_name']}</td>
                    <td>{$row['training_name']}</td>
                    <td>{$row['training_description']}</td>
                    <td>{$row['cost']}</td>
                    <td>{$row['training_provided']}</td>
                    <td>{$row['time']}</td>
                    <td>{$row['day_of_week']}</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='training_id' value='{$row["id"]}'>
                            $reserve_button
                        </form>
                    </td>
                </tr>";
        }
        mysqli_close($con);
        ?>
    </table>

    <br><br>
    <a href="HomePage.php">Back</a>

    <script>
        $(document).ready(function(){
            $('#search').on('keyup', function(){
                var searchText = $(this).val().toLowerCase();
                $('table tr:gt(0)').each(function(){
                    var found = false;
                    $(this).find('td').each(function(){
                        if($(this).text().toLowerCase().indexOf(searchText) >= 0){
                            found = true;
                            return false;
                        }
                    });
                    if(found){
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
