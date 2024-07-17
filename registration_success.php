<?php
session_start();

// Check if the user is logged in, if not show an alert
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   
    echo '<script>alert("Face successfully captured. You can now log in using your face.");</script>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <div class="alert alert-success" role="alert">
                    Registration Successful, <?php echo htmlspecialchars($_SESSION["email"]); ?>! You can now log in using your face.
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
