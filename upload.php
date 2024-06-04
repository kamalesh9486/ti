<?php
session_start();
require_once('config/db.php');

if (!isset($_SESSION['register_number'])) {
    die("No register number found. Please submit the form first.");
}

if (!isset($_SESSION['grievance_type'])) {
    die("No grievance type found. Please submit the form first.");
}

$register_number = $_SESSION['register_number'];
$grievanceType = $_SESSION['grievance_type']; // Retrieve grievance type from session

// Define the directory to save uploaded files
$uploadDir = 'uploads/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$documents = [];
for ($i = 1; $i <= 9; $i++) {
    $docField = 'document' . $i;
    if (isset($_FILES[$docField]) && $_FILES[$docField]['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES[$docField]['tmp_name'];
        $fileName = $_FILES[$docField]['name'];
        $destPath = $uploadDir . basename($fileName);

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $documents[$docField] = $destPath;
        } else {
            $documents[$docField] = null;
        }
    } else {
        $documents[$docField] = null;
    }
}

// Prepare the SQL query
$query = "INSERT INTO grievances1 (
    register_number, grievance_type, document1, document2, document3,
    document4, document5, document6, document7, document8, document9
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($con, $query);
if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'sssssssssss', 
        $register_number, 
        $grievanceType, 
        $documents['document1'], 
        $documents['document2'], 
        $documents['document3'], 
        $documents['document4'], 
        $documents['document5'], 
        $documents['document6'], 
        $documents['document7'], 
        $documents['document8'], 
        $documents['document9']
    );

    if (mysqli_stmt_execute($stmt)) {
        echo "Documents uploaded successfully.";
    } else {
        echo "Error: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "Error preparing statement: " . mysqli_error($con);
}

mysqli_close($con);
?>
