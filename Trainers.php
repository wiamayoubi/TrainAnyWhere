
<!DOCTYPE html>
<html>
<head>
    <title>Rating</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        main {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        .trainer {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .trainer h2 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .rating {
            text-align: center;
            margin-bottom: 20px;
        }

        .rating-stars {
            display: inline-block;
        }

        .submit-rating {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-rating:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
<main>
    <h1>Our Trainers</h1>

    <?php
    session_start();
    require 'connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) { 
            $userId = $_SESSION['user_id'];
            $trainerId = $_POST['trainer_id'];
            if(isset($_POST['rating'])) {
                $rating = $_POST['rating'];
                // Insert rating into database
                $query = "INSERT INTO ratingtrainer (user_id, trainer_id, rating) VALUES (?, ?, ?)";
                $stmt = mysqli_prepare($con, $query);
                mysqli_stmt_bind_param($stmt, "iii", $userId, $trainerId, $rating);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<p>Thank you for rating the trainer!</p>";
                } else {
                    echo "<p>Error: " . $query . "<br>" . mysqli_error($con) . "</p>";
                }

                mysqli_stmt_close($stmt);
            } else {
                // Display error message if rating value is not set
                echo "<p>Error: Rating value is not set!</p>";
            }
        } else {
            echo "<p>Error: User ID is not set or empty!</p>";
        }
    }

    $query = "SELECT * FROM trainer";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<div class="trainer">';
        echo '<h2>' . $row['name'] . '</h2>';
        echo '<form action="" method="POST">';
        echo '<input type="hidden" name="trainer_id" value="' . $row['trainer_id'] . '">';
        echo '<div id="rating-stars-' . $row['trainer_id'] . '" class="rating-stars"></div>';
        echo '<input type="hidden" name="rating" id="trainer-' . $row['trainer_id'] . '-rating" value="">';
        echo '<input type="submit" class="submit-rating" value="Submit Rating">';
        echo '</form>';
        echo '</div>';
    }
    ?>

</main>

<a href="HomePage.php">Back</a>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize RateYo for each trainer
        <?php
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_assoc($result)) {
            echo '$("#rating-stars-' . $row['trainer_id'] . '").rateYo({';
            echo 'rating: 0,';
            echo 'fullStar: true,';
            echo 'onSet: function (rating, rateYoInstance) {';
            echo '$("#trainer-' . $row['trainer_id'] . '-rating").val(rating);';
            echo '}';
            echo '});';
        }
        ?>
    });
</script>
</body>
</html>