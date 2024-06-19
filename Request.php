<?php
session_start();
require 'connection.php';

if (!isset($_SESSION['trainer_id'])) {
    header("Location: login.php");
    exit();
}

$trainer_id = $_SESSION['trainer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['approve_class'])) {
        $class_id = $_POST['class_id'];

        $update_query = "UPDATE classregistration SET status = 'approved' WHERE class_id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "i", $class_id);
        if (mysqli_stmt_execute($stmt)) {
            echo "<p>Class registration approved!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($con) . "</p>";
        }
        mysqli_stmt_close($stmt);
    } elseif (isset($_POST['approve_personal_training'])) {
        $training_id = $_POST['training_id'];

        $update_query = "UPDATE personaltrainingregistration SET status = 'approved' WHERE registration_id = ?";
        $stmt = mysqli_prepare($con, $update_query);
        mysqli_stmt_bind_param($stmt, "i", $training_id);
        if (mysqli_stmt_execute($stmt)) {
            $move_query = "INSERT INTO approved_personal_training_registrations (user_id, registration_id, status) 
                           SELECT user_id, registration_id, 'approved' FROM personaltrainingregistration WHERE registration_id = ?";
            $stmt = mysqli_prepare($con, $move_query);
            mysqli_stmt_bind_param($stmt, "i", $training_id);
            mysqli_stmt_execute($stmt);
            echo "<p>Personal training registration approved!</p>";
        } else {
            echo "<p>Error: " . mysqli_error($con) . "</p>";
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch class registration requests sent to the logged-in trainer
$class_reservations_query = "SELECT 
                                cr.user_id, 
                                u.username AS user_name, 
                                c.training_id, 
                                t.name AS training_name, 
                                cr.class_id, 
                                cr.status,
                                c.time,
                                c.day_of_week,
                                c.class_type,
                                g.name AS gym_name
                             FROM 
                                classregistration cr 
                             INNER JOIN 
                                class c ON cr.class_id = c.class_id 
                             INNER JOIN 
                                user u ON cr.user_id = u.user_id
                             INNER JOIN 
                                training t ON c.training_id = t.training_id
                             INNER JOIN 
                                gym g ON c.gym_id = g.gym_id
                             WHERE 
                                c.trainer_id = ? AND cr.status <> 'approved'";
$stmt = mysqli_prepare($con, $class_reservations_query);
mysqli_stmt_bind_param($stmt, "i", $trainer_id);
mysqli_stmt_execute($stmt);
$class_reservations_result = mysqli_stmt_get_result($stmt);

// Fetch personal training registration requests sent to the logged-in trainer
$personal_training_registration_query = "SELECT 
                                            ptr.user_id, 
                                            u.username AS user_name, 
                                            ptr.training_id, 
                                            pt.training_name, 
                                            pt.training_provided, 
                                            pt.day_of_week, 
                                            pt.time, 
                                            ptr.status,
                                            ptr.registration_id
                                         FROM 
                                            personaltrainingregistration ptr 
                                         INNER JOIN 
                                            personaltraining pt ON ptr.training_id = pt.id
                                         INNER JOIN 
                                            user u ON ptr.user_id = u.user_id
                                         WHERE 
                                            pt.trainer_id = ? AND ptr.status <> 'approved'";
$stmt = mysqli_prepare($con, $personal_training_registration_query);
mysqli_stmt_bind_param($stmt, "i", $trainer_id);
mysqli_stmt_execute($stmt);
$personal_training_registration_result = mysqli_stmt_get_result($stmt);

// Fetch approved class registrations for the logged-in trainer
$approved_class_registrations_query = "SELECT cr.user_id, u.username AS user_name, c.training_id, t.name AS training_name, cr.class_id, cr.status 
                                       FROM classregistration cr 
                                       INNER JOIN class c ON cr.class_id = c.class_id 
                                       INNER JOIN user u ON cr.user_id = u.user_id
                                       INNER JOIN training t ON c.training_id = t.training_id
                                       WHERE c.trainer_id = ? AND cr.status = 'approved'";
$stmt = mysqli_prepare($con, $approved_class_registrations_query);
mysqli_stmt_bind_param($stmt, "i", $trainer_id);
mysqli_stmt_execute($stmt);
$approved_class_registrations_result = mysqli_stmt_get_result($stmt);

// Fetch approved personal training registrations for the logged-in trainer
$approved_personal_training_registrations_query = "SELECT ptr.user_id, u.username AS user_name, ptr.status 
                                                   FROM approved_personal_training_registrations ptr 
                                                   INNER JOIN personaltrainingregistration pt ON ptr.registration_id = pt.registration_id
                                                   INNER JOIN personaltraining p ON pt.training_id = p.id
                                                   INNER JOIN user u ON ptr.user_id = u.user_id
                                                   WHERE p.trainer_id = ?";
$approved_stmt = mysqli_prepare($con, $approved_personal_training_registrations_query);
mysqli_stmt_bind_param($approved_stmt, "i", $trainer_id);
mysqli_stmt_execute($approved_stmt);
$approved_personal_training_registrations_result = mysqli_stmt_get_result($approved_stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f0f0f0;
        }
        h2 {
            margin-top: 0;
        }
        h3 {
            margin-top: 20px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #ffffff;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        form {
            display: inline-block;
        }
        button {
            padding: 5px 10px;
            margin-right: 5px;
            border: none;
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
        a {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #4caf50;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h2><center>User Reservation Requests</center></h2>

<h3>Class Registration Requests</h3>
<table border="1">
    <tr>
        <th>User Name</th>
        <th>Training Name</th>
        <th>Gym</th>
        <th>Day of Week</th>
        <th>Time</th>
        <th>Class Type</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($class_reservations_result)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['training_name']); ?></td>
            <td><?php echo htmlspecialchars($row['gym_name']); ?></td>
            <td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
            <td><?php echo htmlspecialchars($row['time']); ?></td>
            <td><?php echo htmlspecialchars($row['class_type']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($row['class_id']); ?>">
                    <button type="submit" name="approve_class">Approve</button>
                </form>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<h3>Personal Training Registration Requests</h3>
<table border="1">
    <tr>
        <th>User Name</th>
        <th>Training Name</th>
        <th>Training Provided</th>
        <th>Day of Week</th>
        <th>Time</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($personal_training_registration_result)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars
($row['training_name']); ?></td>
<td><?php echo htmlspecialchars($row['training_provided']); ?></td>
<td><?php echo htmlspecialchars($row['day_of_week']); ?></td>
<td><?php echo htmlspecialchars($row['time']); ?></td>
<td><?php echo htmlspecialchars($row['status']); ?></td>
<td>
<form method="POST" action="">
<input type="hidden" name="training_id" value="<?php echo htmlspecialchars($row['registration_id']); ?>">
<button type="submit" name="approve_personal_training">Approve</button>
</form>
</td>
</tr>
<?php endwhile; ?>

</table>
<h3>Approved Class Registrations</h3>
<table border="1">
    <tr>
        <th>User Name</th>
        <th>Training Name</th>
        <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($approved_class_registrations_result)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['training_name']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<h3>Approved Personal Training Registrations</h3>
<table border="1">
    <tr>
        <th>User Name</th>
        <th>Status</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($approved_personal_training_registrations_result)) : ?>
        <tr>
            <td><?php echo htmlspecialchars($row['user_name']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="HomePage.php">Back</a>

</body>
</html>