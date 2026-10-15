<?php
// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Retrieve and sanitize form inputs
    $name     = htmlspecialchars($_POST['Name'] ?? '');
    $email    = htmlspecialchars($_POST['Email'] ?? '');
    $age      = htmlspecialchars($_POST['Age'] ?? '');
    $dob      = htmlspecialchars($_POST['trip-start'] ?? '');
    $gender   = htmlspecialchars($_POST['Gender'] ?? 'Not Specified');
    $country  = htmlspecialchars($_POST['country'] ?? '');
    $address  = htmlspecialchars($_POST['Address'] ?? '');
    
    // Retrieve checkboxes as an array
    $subjects = isset($_POST['subject']) ? $_POST['subject'] : [];

    // Handle file upload
    $uploadDir = "uploads/";
    // Create uploads directory if it doesn't exist
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $uploadedFileName = "No file uploaded";
    if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] == UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['myfile']['name']);
        $targetFilePath = $uploadDir . uniqid() . "_" . $originalName;
        
        if (move_uploaded_file($_FILES['myfile']['tmp_name'], $targetFilePath)) {
            $uploadedFileName = $originalName;
        }
    }
} else {
    // If someone accesses action.php directly without submitting, redirect them back
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Summary</title>
    <link rel="stylesheet" href="Style.CSS">
</head>
<body>
    <div class="result-container">
        <h1>Registration Successful!</h1>
        <hr>
        <p><b>Name:</b> <?php echo $name; ?></p>
        <p><b>Email:</b> <?php echo $email; ?></p>
        <p><b>Age:</b> <?php echo $age; ?></p>
        <p><b>Date of Birth:</b> <?php echo $dob; ?></p>
        <p><b>Gender:</b> <?php echo $gender; ?></p>
        <p><b>Subjects:</b> <?php echo !empty($subjects) ? implode(', ', array_map('htmlspecialchars', $subjects)) : 'None selected'; ?></p>
        <p><b>Country:</b> <?php echo $country; ?></p>
        <p><b>Address:</b> <?php echo nl2br($address); ?></p>
        <p><b>Uploaded File:</b> <?php echo $uploadedFileName; ?></p>
    </div>
</body>
</html>