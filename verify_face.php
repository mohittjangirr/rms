<?php
session_start();
include('includes/config.php');

$inputDescriptor = json_decode(file_get_contents('php://input'), true)['descriptor'];

// Fetch stored descriptors from the database
$sql = "SELECT UserName, FaceDescriptor FROM admin";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

$isRecognized = false;

foreach ($results as $result) {
    $storedDescriptor = json_decode($result->FaceDescriptor);
    $distance = calculateEuclideanDistance($storedDescriptor, $inputDescriptor);

    if ($distance < 0.6) { // Threshold for face recognition
        $isRecognized = true;
        $_SESSION['alogin'] = $result->UserName;
        break;
    }
}

echo json_encode(['success' => $isRecognized]);

function calculateEuclideanDistance($a, $b) {
    $sum = 0.0;
    for ($i = 0; $i < count($a); $i++) {
        $sum += pow($a[$i] - $b[$i], 2);
    }
    return sqrt($sum);
}
?>
