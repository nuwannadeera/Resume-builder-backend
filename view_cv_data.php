<?php

//handle CORS policy error
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit();
}

include 'connection.php';

$request = $_GET['user_id'];
$query5 = "SELECT * FROM resume_user
                        WHERE resume_user.uid = '$request'";
$user_data = array();
$result = mysqli_query($conn, $query5);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $user_data[] = $row;
    }
}

$query6 = "SELECT * FROM education
                        WHERE education.uid = $request";
$edu_data = array();
$result = mysqli_query($conn, $query6);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $edu_data[] = $row;
    }
}

$query7 = "SELECT * FROM experience
                        WHERE experience.uid = $request";
$exp_data = array();
$result = mysqli_query($conn, $query7);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $exp_data[] = $row;
    }
}

$query8 = "SELECT * FROM skills
                        WHERE skills.uid = $request";
$skill_data = array();
$result = mysqli_query($conn, $query8);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $skill_data[] = $row;
    }
}
echo json_encode(array($user_data, $edu_data, $exp_data, $skill_data));
mysqli_close($conn);
?>
