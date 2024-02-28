<?php
include 'db_connect.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$answers = json_decode($_POST['answers'], true);


$results = array();

foreach ($answers as $questionId => $userAnswer) {
 
    $query = $conn->prepare("SELECT bonnerep FROM feur WHERE qcmId = ?");
    $query->bind_param('i', $questionId);
    $query->execute();
    $query->bind_result($correctAnswer);
    $query->fetch();
    $query->close();


    $isCorrect = ($userAnswer === $correctAnswer);

 
    $results[$questionId] = $isCorrect;
}


echo json_encode($results);
?>
