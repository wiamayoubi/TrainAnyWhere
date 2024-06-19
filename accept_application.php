<?php
require 'connection.php';

if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    $query = "SELECT * FROM trainer_applications WHERE application_id='$application_id'";
    $result = mysqli_query($con, $query);
    if ($row = mysqli_fetch_assoc($result)) {
        $full_name = $row['full_name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $application_id = $_POST['application_id'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Add to trainers table
    $add_query = "INSERT INTO trainer (name, email, mobile, username, password) 
                  VALUES ('$full_name', '$email', '$mobile', '$username', '$password')";
    if (mysqli_query($con, $add_query)) {
        // Delete from trainer_applications
        $delete_query = "DELETE FROM trainer_applications WHERE application_id='$application_id'";
        mysqli_query($con, $delete_query);
        header("Location: file.php?message=Trainer added successfully");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Trainer</title>
</head>
<body>
    <h1>Insert new Trainer</h1>
    <form method="post">
        <input type="hidden" name="application_id" value="<?php echo $application_id; ?>">
        <p>Full Name: <input type="text" name="full_name" value="<?php echo $full_name; ?>" readonly></p>
        <p>Email: <input type="text" name="email" value="<?php echo $email; ?>" readonly></p>
        <p>Mobile: <input type="text" name="mobile" value="<?php echo $mobile; ?>" readonly></p>
        <p>Username: <input type="text" name="username" required></p>
        <p>Password: <input type="password" name="password" required></p>
        <p><input type="submit" value="Add Trainer"></p>
    </form>
    <a href="file.php">Back</a>
</body>
</html>
