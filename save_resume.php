<?php

//handle CORS policy error
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit();
}

include 'connection.php';

$postdata = file_get_contents("php://input");
$param = json_decode($postdata, TRUE);
$user = $param['user'];
$eduList = $param['eduList'];
$expList = $param['expList'];
$skillList = $param['skillList'];

$title = $user['title'];
$name = $user['name'];
$post = $user['post'];
$address = $user['address'];
$contact_no = $user['contact_no'];
$email = $user['email'];
$date_of_birth = $user['date_of_birth'];
$linkedin_profile = $user['linkedin_profile'];

$has_error = 0;
$user_index = -1;
mysqli_autocommit($conn, FALSE);

$query4 = "INSERT INTO resume_user
           (`title`
           ,`post`
           ,`full_name`
           ,`address`
           ,`email`
           ,`mobile_no`
           ,`birth_date`
           ,`linkedin_profile`)
     VALUES('$title','$post','$name','$address','$email', '$contact_no'
         ,'$date_of_birth','$linkedin_profile')";
if ($conn->query($query4) === TRUE) {
    $user_index = $conn->insert_id;
} else {
    $has_error = 1;
    header("HTTP/1.1 500 Internal Server Error");
    echo '{"data": "Exception occurred: ' . mysqli_error($conn) . '"}';
    mysqli_rollback($conn);
}

for ($x = 0; $x < sizeof($eduList); $x++) {
    $course_name = $eduList[$x]['course_name'];
    $institute = $eduList[$x]['institute'];
    $start_date = $eduList[$x]['start_date'];
    $end_date = $eduList[$x]['end_date'];

    $query2 = "INSERT INTO education
           (`uid`
           ,`course_name`
           ,`institute`
           ,`start_date`
           ,`end_date`)
     VALUES($user_index,'$course_name','$institute','$start_date','$end_date')";
    if ($conn->query($query2) === TRUE) {
        $conn->insert_id;
    } else {
        $has_error = 1;
        header("HTTP/1.1 500 Internal Server Error");
        echo '{"data": "Exception occurred: ' . mysqli_error($conn) . '"}';
        mysqli_rollback($conn);
    }
}

for ($x = 0; $x < sizeof($expList); $x++) {
    $position = $expList[$x]['position'];
    $company = $expList[$x]['company'];
    $start_date = $expList[$x]['start_date'];
    $end_date = $expList[$x]['end_date'];
    $description = array_key_exists('description', $expList[$x]) ?
        $expList[$x]['description'] : $expList[$x]['description'] = "";

    $query3 = "INSERT INTO experience
           (`uid`
           ,`position`
           ,`company`
           ,`start_date`
           ,`description`
           ,`end_date`)
     VALUES($user_index,'$position','$company','$start_date','$description','$end_date')";
    if ($conn->query($query3) === TRUE) {
        $conn->insert_id;
    } else {
        $has_error = 1;
        header("HTTP/1.1 500 Internal Server Error");
        echo '{"data": "Exception occurred: ' . mysqli_error($conn) . '"}';
        mysqli_rollback($conn);
    }
}

for ($x = 0; $x < sizeof($skillList); $x++) {
    $skill = $skillList[$x]['skill'];

    $query5 = "INSERT INTO skills
           (`uid`
           ,`skill`)
     VALUES($user_index,'$skill')";
    if ($conn->query($query5) === TRUE) {
        $conn->insert_id;
    } else {
        $has_error = 1;
        header("HTTP/1.1 500 Internal Server Error");
        echo '{"data": "Exception occurred: ' . mysqli_error($conn) . '"}';
        mysqli_rollback($conn);
    }
}
if (!$has_error) {
    mysqli_commit($conn);
    echo $user_index;
} else {
    mysqli_rollback($conn);
}
mysqli_close($conn);
?>
