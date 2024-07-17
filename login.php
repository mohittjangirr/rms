<?php
session_start();

// Include database connection file
include('includes/config.php');

if(isset($_POST['login'])) {
    $email = $_POST['email']; // Assuming the input field is named "email"
    $faceData = $_POST['face_data']; // Base64 encoded face image data
    
    // Check if face data is captured
    if(empty($faceData)) {
        $error = "Please capture your face before logging in.";
    } else {
        // Fetch the user's face data from the database based on the email
        $sql = "SELECT FaceData FROM admin WHERE Email = :email";
        $stmt = $dbh->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $storedFaceData = $stmt->fetchColumn();

        if($storedFaceData) {
            // Compare the captured face data with the stored face data
            if($faceData == $storedFaceData) {
                // Face data matches, grant access
                $_SESSION['email'] = $email; // You can store more user information in the session if needed
                header("Location: dashboard.php"); // Redirect to dashboard or any other page
                exit();
            } else {
                // Face data doesn't match, deny access
                $error = "Face recognition failed. Please try again.";
            }
        } else {
            // User not found in the database
            $error = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Face Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* CSS styles remain same as provided earlier */
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="outer-container">
                    <div class="logo-text">ACEDEMIA</div>
                    <div class="tagline-text">Admin Face Login</div>
                    <div class="inner-container">
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                                <label for="email">Gmail</label>
                            </div>
                            <div id="video-container">
                                <video id="video" width="100%" height="auto" autoplay></video>
                                <div id="overlay"></div>
                            </div>
                            <button type="button" class="btn btn-custom mt-3" id="captureButton">Capture</button>
                            <input type="hidden" id="face_data" name="face_data">
                            <button type="submit" class="btn btn-success mt-3" name="login">Login</button>
                            <?php if(isset($error)) { ?>
                                <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include face-api.js library -->
    <script src="/dist/face-api.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            const video = document.getElementById('video');
            const captureButton = document.getElementById('captureButton');
            const faceDataInput = document.getElementById('face_data');

            // Function to start the video stream and request camera access
            function startVideo() {
                // Request access to the camera
                navigator.mediaDevices.getUserMedia({ video: true })
                    .then(stream => {
                        // Set the video source to the stream
                        video.srcObject = stream;
                        // Play the video
                        video.play();
                    })
                    .catch(err => {
                        // Handle errors, for example, permission denied
                        console.error('Error accessing camera:', err);
                        alert('Error accessing camera. Please make sure your browser has access to the camera.');
                    });
            }

            // Load face-api.js models and start the video stream
            Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri('/models'),
                faceapi.nets.faceLandmark68Net.loadFromUri('/models')
            ]).then(startVideo).catch(err => {
                console.error('Error loading models:', err);
                alert('Error loading face detection models. Please try again later.');
            });

            // Function to capture the face image and extract facial landmarks
            captureButton.addEventListener('click', async () => {
                const detections = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions()).withFaceLandmarks();
                if (detections) {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
                    faceDataInput.value = canvas.toDataURL('image/jpeg');
                } else {
                    alert('No face detected. Please make sure your face is visible in the camera frame.');
                }
            });
        });
    </script>
</body>
</html>
