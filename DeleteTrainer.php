<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Trainer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
        select, input[type="submit"] {
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
        <h2>Delete a Trainer</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="trainer_id" class="form-label">Select Trainer:</label>
                <select name="trainer_id" id="trainer_id" class="form-select" required>
                    <?php
                    require 'connection.php';
                    $query = "SELECT trainer_id, name FROM trainer";
                    $result = mysqli_query($con, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['trainer_id']}'>{$row['name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <input type="submit" name="sb" value="Delete" class="btn btn-danger">
        </form>

        <?php 
        if (isset($_POST["sb"])) {
            $trainer_id = $_POST['trainer_id'];
            require 'connection.php';

            // Start a transaction
            mysqli_begin_transaction($con);

            try {
                // Delete records in personaltrainingregistration related to personaltraining
                $query = "DELETE ptr 
                          FROM personaltrainingregistration ptr 
                          JOIN personaltraining pt ON ptr.training_id = pt.id 
                          WHERE pt.trainer_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $trainer_id);
                mysqli_stmt_execute($stmt);

                // Delete records in personaltraining related to the trainer
                $query = "DELETE FROM personaltraining WHERE trainer_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $trainer_id);
                mysqli_stmt_execute($stmt);

                // Delete records in ratingtrainer related to the trainer
                $query = "DELETE FROM ratingtrainer WHERE trainer_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $trainer_id);
                mysqli_stmt_execute($stmt);

                // Delete the trainer
                $query = "DELETE FROM trainer WHERE trainer_id = ?";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "i", $trainer_id);
                mysqli_stmt_execute($stmt);

                // Commit the transaction
                mysqli_commit($con);

                echo "<div class='alert alert-success' role='alert'>Trainer has been deleted successfully</div>";
            } catch (Exception $e) {
                // Rollback the transaction in case of an error
                mysqli_rollback($con);
                echo "<div class='alert alert-danger' role='alert'>Error deleting trainer and related records: " . $e->getMessage() . "</div>";
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
