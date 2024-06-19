<?php
require_once 'connection.php';

function saveApplicationDetails($con, $full_name, $email, $mobile, $certificate_file, $resume_file) {
    $query = "INSERT INTO trainer_applications (full_name, email, mobile, certificate_file, resume_file) 
              VALUES ('$full_name', '$email', '$mobile', '$certificate_file', '$resume_file')";
    return mysqli_query($con, $query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    
    $certificate_file = "";
    $resume_file = "";

    if (isset($_FILES['certificate']) && $_FILES['certificate']['error'][0] === UPLOAD_ERR_OK) {
        $certificate_file = basename($_FILES['certificate']['name'][0]);
        $certificate_file_path = "uploads/" . $certificate_file;
        move_uploaded_file($_FILES['certificate']['tmp_name'][0], $certificate_file_path);
    }
    
    if (isset($_FILES['resume']) && $_FILES['resume']['error'][0] === UPLOAD_ERR_OK) {
        $resume_file = basename($_FILES['resume']['name'][0]);
        $resume_file_path = "uploads/" . $resume_file;
        move_uploaded_file($_FILES['resume']['tmp_name'][0], $resume_file_path);
    }

    if (saveApplicationDetails($con, $full_name, $email, $mobile, $certificate_file, $resume_file)) {
        echo "Application submitted successfully.";
    } else {
        echo "Error submitting application: " . mysqli_error($con);
    }
}
?>
