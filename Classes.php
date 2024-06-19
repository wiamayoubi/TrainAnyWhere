<?php
session_start();
require 'connection.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$reservation_error = ""; // Initialize reservation error message

if (isset($_POST['reserve'])) {
    if (isset($_SESSION['user_id']) && isset($_POST['class_id'])) {
        $user_id = $_SESSION['user_id'];
        $class_id = $_POST['class_id'];
        $reserved_class_time = $_POST['class_time']; // Assuming you have a hidden input for class time

        // Check if the user has already registered for this class
        $check_query = "SELECT * FROM classregistration WHERE user_id = '$user_id' AND class_id = '$class_id'";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            $reservation_error = "You have already registered for this class.";
        } else {
            // Check if the user has already reserved a class at the same time
            $check_time_query = "SELECT c.time
                                 FROM classregistration cr
                                 INNER JOIN class c ON cr.class_id = c.class_id
                                 WHERE cr.user_id = '$user_id'";
            $check_time_result = mysqli_query($con, $check_time_query);

            $time_conflict = false;

            while ($row = mysqli_fetch_assoc($check_time_result)) {
                // Check for time conflict
                if ($reserved_class_time === $row['time']) {
                    $time_conflict = true;
                    break;
                }
            }

            if ($time_conflict) {
                $reservation_error = "You have already reserved a class at this time.";
            } else {
                // Proceed with the reservation
                $insert_query = "INSERT INTO classregistration (user_id, class_id) VALUES ('$user_id', '$class_id')";

                if (mysqli_query($con, $insert_query)) {
                    echo "Reservation successful.";
                } else {
                    echo "Error: " . mysqli_error($con);
                }
            }
        }
    } else {
        $reservation_error = "Error: User ID or Class ID not set.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classes</title>
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
    <h1>Reserve for your favorite class</h1>
    <?php if (!empty($reservation_error)) { ?>
        <div style="color: red;"><?php echo $reservation_error; ?></div>
    <?php } ?>
    <input type="text" id="search" autocomplete="off" placeholder="Search...">
    <br><br>

    <table>
        <tr>
            <th>Trainer</th>
            <th>Gym</th>
            <th>Training</th>
            <th>Day of the Week</th>
            <th>Time</th>
            <th>Class Type</th>
            <th>Cost</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "SELECT class.class_id, trainer.name AS trainer_name, gym.name AS gym_name, training.name AS training_name, class.day_of_week, class.time, class.class_type, class.Cost
                  FROM class
                  INNER JOIN trainer ON class.trainer_id = trainer.trainer_id
                  INNER JOIN gym ON class.gym_id = gym.gym_id
                  INNER JOIN training ON class.training_id = training.training_id";
        $result = mysqli_query($con, $query);

        while ($row = mysqli_fetch_array($result)) {
            // Check if the user has already registered for this class
            $disabled = '';
            if ($user_id !== null) {
                $check_query = "SELECT * FROM classregistration WHERE user_id = '$user_id' AND class_id = '" . $row["class_id"] . "'";
                $check_result = mysqli_query($con, $check_query);
                if (mysqli_num_rows($check_result) > 0) {
                    $reserve_button = "<button disabled>Reserved</button>";
                } else {
                    $reserve_button = "<input type='submit' name='reserve' value='Reserve'>";
                }
            } else {
                // If user is not logged in, disable the button
                $reserve_button = "<button disabled>Login Required</button>";
            }

            echo "<tr>
                    <td>" . $row["trainer_name"] . "</td>
                    <td>" . $row["gym_name"] . "</td>
                    <td>" . $row["training_name"] . "</td>
                    <td>" . $row["day_of_week"] . "</td>
                   
                    <td>" . $row["time"] . "</td>
                    <td>" . $row["class_type"] . "</td>
                    <td>" . $row["Cost"] . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='class_id' value='" . $row["class_id"] . "'>
                            <input type='hidden' name='class_time' value='" . $row["time"] . "'> <!-- Hidden input for class time -->
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
    