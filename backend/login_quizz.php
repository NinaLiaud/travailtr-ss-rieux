<?php
include 'db_connect.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$question1 = htmlspecialchars($_POST['1']);
/*$question2 = htmlspecialchars($_POST['2']);
$question3 = htmlspecialchars($_POST['3']);
$question4 = htmlspecialchars($_POST['4']);
$question5 = htmlspecialchars($_POST['5']);
$question6 = htmlspecialchars($_POST['6']);
$question7 = htmlspecialchars($_POST['7']);
$question8 = htmlspecialchars($_POST['8']);
$question9 = htmlspecialchars($_POST['9']);
$question10 = htmlspecialchars($_POST['10']);
*/


$sql = "SELECT * FROM feur WHERE id = 1 AND bonneRep ='$question1'";

$result = mysqli_query($conn, $sql);



if (mysqli_num_rows($result) > 0) {
    $responseData = [
        "message" => "vrai",
        'success' => true
    ];
} else {
    $responseData = [
        "message" => "faux",
        'success' => true
    ];
}


echo json_encode($responseData);
