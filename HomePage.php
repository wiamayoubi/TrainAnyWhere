<?php
session_start();
require 'connection.php';

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Function to fetch classes reserved by the user
function getReservedClasses($con, $user_id) {
    $reserved_classes = array();
    $query = "SELECT 
                class.class_id, 
                trainer.name AS trainer_name, 
                gym.name AS gym_name, 
                training.name AS training_name, 
                class.day_of_week, 
                class.time, 
                class.class_type, 
                class.Cost,
                classregistration.status
              FROM 
                classregistration
              INNER JOIN 
                class ON classregistration.class_id = class.class_id
              INNER JOIN 
                trainer ON class.trainer_id = trainer.trainer_id
              INNER JOIN 
                gym ON class.gym_id = gym.gym_id
              INNER JOIN 
                training ON class.training_id = training.training_id
              WHERE 
                classregistration.user_id = '$user_id'";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $reserved_classes[] = $row;
    }
    return $reserved_classes;
}

function getRegisteredPersonalTraining($con, $user_id) {
    $registered_training = array();
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
                ptr.user_id = '$user_id'
              AND 
                (ptr.status = 'Approved' OR ptr.status = 'Pending')";
    $result = mysqli_query($con, $query);
    while ($row = mysqli_fetch_array($result)) {
        $registered_training[] = $row;
    }
    return $registered_training;
}


// Fetch reserved classes for the user
$reserved_classes = getReservedClasses($con, $user_id);

// Fetch registered personal training sessions for the user
$registered_training = getRegisteredPersonalTraining($con, $user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
    <link href="css/style.min.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="img/favicon.ico" rel="icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
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
            margin: 0 15px;
            font-size: 16px;
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
            text-align: center;
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
        footer p {
            margin: 5px 0;
        }
        img {
            display: block;
            margin: 20px auto;
            max-width: 100%;
            height: auto;
        }
        table {
            margin: 20px auto;
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
    </style>
</head>
<body>
<div class="container-fluid p-0 nav-bar">



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
        }
        .navbar-nav .nav-link {
            color: white;
        }
  
      
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="HomePage.php">TrainAnyWhere</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="HomePage.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Account.php">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Classes.php">Classes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="PersonalTraining.php">Personal Training</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Inquiry.php">Contact</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Trainers.php">Rating</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="Logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
        <!-- <nav class="navbar navbar-expand-lg bg-none navbar-dark py-3">
         
            <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav ml-auto p-4 bg-secondary">
                    <a href="HomePage.php" class="nav-item nav-link active">Home</a>
                    <a href="Account.php" class="nav-item nav-link">Account Details</a>
                    <a href="Classes.php" class="nav-item nav-link">Classes</a>
                    <a href="PersonalTraining.php" class="nav-item nav-link">Personal Training</a>
                    <a href="Inquiry.php" class="nav-item nav-link">Contact</a>
                    <a href="Trainers.php" class="nav-item nav-link">Trainers</a>
                    <a href="Logout.php" class="nav-item nav-link">Logout</a>
                </div>
            </div>
        </nav> -->
    </div>
    <!-- <header>
        <a href="HomePage.php">Home</a>
        <a href="Account.php">Account Details</a>
        <a href="Classes.php">Classes</a>
        <a href="PersonalTraining.php">Personal Training</a>
        <a href="Inquiry.php">Contact</a>
        <a href="Trainers.php">Trainers</a>
        <a href="Logout.php">Logout</a>
    </header> -->
    <main>
        <h1>START SLOWLY AND BUILD YOUR BODY</h1>
        <p>Apply page animations and transitions to your Canva presentation to emphasize ideas and make them even more memorable.</p>
        <p>Follow us <a href="mailto:email@mail.com">email@mail.com</a></p>
    </main>
    <h2>Your Reserved Classes</h2>
    <table>
        <tr>
            <th>Trainer</th>
            <th>Gym</th>
            <th>Training</th>
            <th>Day of the Week</th>
            <th>Time</th>
            <th>Class Type</th>
            <th>Cost</th>
            <th>Status</th>
        </tr>
        <?php foreach ($reserved_classes as $class) { ?>
            <tr>
                <td><?php echo $class['trainer_name']; ?></td>
                <td><?php echo $class['gym_name']; ?></td>
                <td><?php echo $class['training_name']; ?></td>
                <td><?php echo $class['day_of_week']; ?></td>
                <td><?php echo $class['time']; ?></td>
                <td><?php echo $class['class_type']; ?></td>
                <td><?php echo $class['Cost']; ?></td>
                <td><?php echo $class['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <h2>Your Registered Personal Training Sessions</h2>
    <table>
        <tr>
            <th>Trainer</th>
            <th>Training Name</th>
            <th>Training Description</th>
            <th>Cost</th>
            <th>Training Provided</th>
            <th>Time</th>
            <th>Day Of Week</th>
            <th>Status</th>
        </tr>
        <?php foreach ($registered_training as $training) { ?>
            <tr>
                <td><?php echo $training['trainer_name']; ?></td>
                <td><?php echo $training['training_name']; ?></td>
                <td><?php echo $training['training_description']; ?></td>
                <td><?php echo $training['cost']; ?></td>
                <td><?php echo $training['training_provided']; ?></td>
                <td><?php echo $training['time']; ?></td>
                <td><?php echo $training['day_of_week']; ?></td>
                <td><?php echo $training['status']; ?></td>
            </tr>
        <?php } ?>
    </table>
    <footer>
    <h4 class="text-primary mb-4">Get In Touch</h4>
                <p><i class="fa fa-map-marker-alt mr-2"></i>123 Street, El_Koura, Lebanon</p>
                <p><i class="fa fa-phone-alt mr-2"></i>+961 70123456</p>
                <p><i class="fa fa-envelope mr-2"></i>info@example.com</p>
              <center>  
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-light rounded-circle text-center mr-2 px-0" style="width: 40px; height: 40px;" href="#"><i class="fab fa-instagram"></i></a>
                </center>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>

<!-- Contact Javascript File -->
<script src="mail/jqBootstrapValidation.min.js"></script>
<script src="mail/contact.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w5Xr2m3q/Zd+P5FzH4t9w5rmFL7vI4sRskZx2U8RQH6IT3U1Fhcn4sQZhVY2nd+/Z" crossorigin="anonymous"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>
</body>
</html>
