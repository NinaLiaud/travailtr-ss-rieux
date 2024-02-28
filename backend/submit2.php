<?php
include 'db_connect.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$answers = json_decode($_POST['answers'], true);

// Traitement des réponses dans la base de données
$results = array();

foreach ($answers as $questionId => $userAnswer) {
    // Votre logique de comparaison avec la base de données ici
    $query = $conn->prepare("SELECT bonnerep FROM feur WHERE qcmId = ?");
    $query->bind_param('i', $questionId);
    $query->execute();
    $query->bind_result($correctAnswer);
    $query->fetch();
    $query->close();

    // Compare user's answer with the correct answer
    $isCorrect = ($userAnswer === $correctAnswer);

    // Store the result for each question
    $results[$questionId] = $isCorrect;
}

// Return the results as JSON
echo json_encode($results);
?>
