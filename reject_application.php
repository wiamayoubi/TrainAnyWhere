<?php
require 'connection.php';

if (isset($_GET['application_id'])) {
    $application_id = $_GET['application_id'];

    $query = "DELETE FROM trainer_applications WHERE application_id='$application_id'";
    if (mysqli_query($con, $query)) {
        header("Location: file.php?message=Application rejected successfully");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
mysqli_close($con);
?>
