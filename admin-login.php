<?php
session_start();

// Include database connection file
include('includes/config.php');

if(isset($_POST['register'])) {
    $email = $_POST['email']; // Assuming the input field is named "email"
    $faceData = $_POST['face_data']; // Base64 encoded face image data
    $landmarks = $_POST['face_landmarks']; // JSON encoded facial landmarks data
    
    // Insert the user's information, face data, and landmarks into the database
    $sql = "INSERT INTO admin (Email, FaceData, FacialLandmarks) VALUES (:email, :faceData, :landmarks)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':faceData', $faceData, PDO::PARAM_STR);
    $stmt->bindParam(':landmarks', $landmarks, PDO::PARAM_STR);
    $stmt->execute();

    // Redirect to a success page or perform further actions
    header("Location: registration_success.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Face Registration</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
     <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .outer-container {
            background-color: #e9ecef;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
        }
        .inner-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
        }
        .btn-custom {
            background-color: #7a6ad8;
            color: white;
            border: 2px solid #7a6ad8;
            border-radius: 25px;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .btn-custom:hover {
            background-color: #695bc3;
            border-color: #695bc3;
        }
        .logo-text {
            font-size: 2.5rem;
            font-weight: 600;
            color: #7a6ad8;
        }
        .tagline-text {
            font-size: 1rem;
            font-weight: 400;
            color: #7a6ad8;
            margin-top: -10px;
            animation: fadeIn 2s ease-in-out;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .form-control {
            border-radius: 10px;
            padding: 17px;
            height: auto;
        }
        .form-control:focus {
            border-color: #695bc3;
            box-shadow: none;
        }
        label {
            color: #7a6ad8;
            font-weight: 400;
            position: absolute;
            top: -10px;
            left: 15px;
            background: #ffffff;
            padding: 0 5px;
            transition: all 0.3s;
        }
        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .form-floating input:not(:placeholder-shown) + label {
            font-size: 0.85rem;
            top: -30px;
            color: #695bc3;
        }
        #video-container {
            position: relative;
            width: 100%;
            margin-top: 20px;
        }
        #video-feed {
            display: block;
            width: 100%;
        }
        #overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        #overlay canvas {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
        }
        .alert-danger {
            margin-top: 20px;
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="outer-container">
                    <div class="logo-text">ACEDEMIA</div>
                    <div class="tagline-text">Admin Face Registration</div>
                    <div class="inner-container">
                        <form method="post" enctype="multipart/form-data">
                            <!-- Input field for email -->
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder=" " required>
                                <label for="email">Gmail</label>
                            </div>
                            <!-- Video container and capture button -->
                            <div id="video-container">
                                <video id="video" width="100%" height="auto" autoplay></video>
                                <div id="overlay"></div>
                            </div>
                            <button type="button" class="btn btn-custom mt-3" id="captureButton">Capture</button>
                            <!-- Hidden input fields for face data and facial landmarks -->
                            <input type="hidden" id="face_data" name="face_data">
                            <input type="hidden" id="face_landmarks" name="face_landmarks">
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-success mt-3" name="register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include face-api.js library -->
    <script src="/dist/face-api.min.js"></script>
    <!-- JavaScript code -->
    <script>
    
     document.addEventListener("DOMContentLoaded", function(event) {
    const video = document.getElementById('video');
    const captureButton = document.getElementById('captureButton');
    const registerButton = document.getElementById('registerButton');
    const faceDataInput = document.getElementById('face_data');
    const faceLandmarksInput = document.getElementById('face_landmarks');

    // Function to start the video stream and request camera access
    function startVideo() {
        // Request access to the camera
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                // Set the video source to the stream
                video.srcObject = stream;
                // Play the video
                video.play();
                // Enable the capture button
                captureButton.disabled = false;
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

            // Extract and stringify facial landmarks
            const landmarks = detections.landmarks.toJSON();
            faceLandmarksInput.value = JSON.stringify(landmarks);
            // Enable the register button
            registerButton.disabled = false;
        } else {
            alert('No face detected. Please make sure your face is visible in the camera frame.');
        }
    });
});
</script>
</body>
</html>
