<?php
session_start();
require 'connection.php';

// Fetch trainers from the database
$trainers_query = "SELECT trainer_id, name FROM trainer";
$trainers_result = mysqli_query($con, $trainers_query);

// Fetch gyms from the database
$gyms_query = "SELECT gym_id, name FROM gym";
$gyms_result = mysqli_query($con, $gyms_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize user inputs
    $inquiry_type = $_POST['inquiry_type'] ?? '';
    $message = $_POST['message'] ?? '';
    $user_id = $_SESSION['user_id'] ?? 0;

    if (empty($inquiry_type) || empty($message) || empty($user_id)) {
        // Handle validation errors or missing data
        echo "Please fill in all required fields.";
        exit();
    }

    // Ensure consistent naming convention for receiver types
    $receiver_type = ($inquiry_type === 'trainer') ? 'trainer' : 'gym';

    // Determine the receiver ID based on the inquiry type
    if ($receiver_type === 'trainer') {
        $receiver_id = $_POST['trainer'] ?? 0;

        // Insert the inquiry into the trainer_inquiries table
        $insert_query = "INSERT INTO trainer_inquiries (user_id, trainer_id, message, is_read) VALUES (?, ?, ?, 0)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "iis", $user_id, $receiver_id, $message);
    } else {
        $admin_type = $_POST['admin_type'] ?? '';
        if ($admin_type === 'trainer') {
            $receiver_id = $_POST['admin_trainer'] ?? 0;
        } else {
            $receiver_id = $_POST['gym'] ?? 0;
        }

        // Insert the inquiry into the admin_inquiries table
        $insert_query = "INSERT INTO admin_inquiries (user_id, receiver_type, receiver_id, message, is_read) VALUES (?, ?, ?, ?, 0)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "isis", $user_id, $receiver_type, $receiver_id, $message);
    }
    
    if (mysqli_stmt_execute($stmt)) {
        // Inquiry successfully inserted
        header('Location: HomePage.php?inquiry=success');
        exit();
    } else {
        // Handle database error
        echo "Error: " . mysqli_error($con);
    }

    mysqli_stmt_close($stmt);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inquiry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
      <!-- Favicon -->
      <link href="img/favicon.ico" rel="icon">

      <!-- Font Awesome -->
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  
      <!-- Flaticon Font -->
      <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">
  
      <!-- Customized Bootstrap Stylesheet -->
      <link href="css/style.min.css" rel="stylesheet">
</head>
<body>
<div class="container pt-5">
    <div class="d-flex flex-column text-center mb-5">
        <h4 class="text-primary font-weight-bold">Get In Touch</h4>
        <h4>Email Us For Any Query Or Submit Your Query Here</h4>
    </div>

    <div class="row px-3 pb-2">
        <div class="col-sm-4 text-center mb-3">
            <i class="fa fa-2x fa-map-marker-alt mb-3 text-primary"></i>
            <h4 class="font-weight-bold">Address</h4>
            <p>123 Street, El_Koura, Lebanon</p>
        </div>
        <div class="col-sm-4 text-center mb-3">
            <i class="fa fa-2x fa-phone-alt mb-3 text-primary"></i>
            <h4 class="font-weight-bold">Phone</h4>
            <p>+961 70123456</p>
        </div>
        <div class="col-sm-4 text-center mb-3">
            <i class="far fa-2x fa-envelope mb-3 text-primary"></i>
            <h4 class="font-weight-bold">Email</h4>
            <p>info@example.com</p>
        </div>
    </div>

    <div class="container">
        <div>
            <h1>Gym Contact Details</h1>
            <div class="row">
                <div class="col-sm-6 mb-3">
                    <h2>Kfarhata Gym</h2>
                    <p><i class="far fa-envelope mb-3 text-primary"></i> kfarhatagym@gmail.com</p>
                    <p><i class="fa fa-phone-alt mb-3 text-primary"></i> +961 06922911</p>
                </div>
                <div class="col-sm-6 mb-3">
                    <h2>Fitness360 Gym</h2>
                    <p><i class="far fa-envelope mb-3 text-primary"></i> Fitness360@gmail.com</p>
                    <p><i class="fa fa-phone-alt mb-3 text-primary"></i> +961 06922922</p>
                </div>
                <div class="col-sm-6 mb-3">
                    <h2>LIU Gym</h2>
                    <p><i class="far fa-envelope mb-3 text-primary"></i> liugym@gmail.com</p>
                    <p><i class="fa fa-phone-alt mb-3 text-primary"></i> +961 06922933</p>
                </div>
            </div>
        </div>

     <br><br><br>
        <form action="" method="POST">
            <label for="inquiry_type">Select Inquiry Type:</label>
            <select name="inquiry_type" id="inquiry_type">
                <option value="trainer">Inquiry to Trainer</option>
                <option value="admin">Inquiry to Administrator</option>
            </select>
            <div id="trainer_inquiry">
                <label for="trainer">Select Trainer:</label>
                <select name="trainer" id="trainer_select">
                    <?php while ($trainer = mysqli_fetch_assoc($trainers_result)): ?>
                        <option value="<?php echo $trainer['trainer_id']; ?>"><?php echo htmlspecialchars($trainer['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div id="admin_inquiry" style="display: none;">
                <label for="admin_type">Select Admin Type:</label>
                <select name="admin_type" id="admin_type">
                    <option value="trainer">Trainer</option>
                    <option value="gym">Gym</option>
                </select>
                <div id="admin_trainer_select" style="display: none;">
                    <label for="admin_trainer">Select Trainer:</label>
                    <select name="admin_trainer" id="admin_trainer">
                        <?php mysqli_data_seek($trainers_result, 0); // Reset the pointer to fetch trainers again ?>
                        <?php while ($trainer = mysqli_fetch_assoc($trainers_result)): ?>
                            <option value="<?php echo $trainer['trainer_id']; ?>"><?php echo htmlspecialchars($trainer['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div id="gym_select" style="display: none;">
                    <label for="gym">Select Gym:</label>
                    <select name="gym" id="gym">
                        <?php while ($gym = mysqli_fetch_assoc($gyms_result)): ?>
                            <option value="<?php echo $gym['gym_id']; ?>"><?php echo htmlspecialchars($gym['name']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>
            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="4" cols="50"></textarea>
            <input type="submit" value="Submit">
        </form>
        <a class="back-link" href="HomePage.php">Back</a>
    </div>

    <script>
        document.getElementById('inquiry_type').addEventListener('change', function() {
            var inquiryType = this.value;
            if (inquiryType === 'trainer') {
                document.getElementById('trainer_inquiry').style.display = 'block';
                document.getElementById('admin_inquiry').style.display = 'none';
            } else if (inquiryType === 'admin') {
                document.getElementById('admin_inquiry').style.display = 'block';
                document.getElementById('trainer_inquiry').style.display = 'none';
            }
        });
        document.getElementById('admin_type').addEventListener('change', function() {
            var adminType = this.value;
            if (adminType === 'trainer') {
                document.getElementById('admin_trainer_select').style.display = 'block';
                document.getElementById('gym_select').style.display = 'none';
            } else if (adminType === 'gym') {
                document.getElementById('gym_select').style.display = 'block';
                document.getElementById('admin_trainer_select').style.display = 'none';
            }
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            max-width: 600px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        select, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

</body>
</html>


