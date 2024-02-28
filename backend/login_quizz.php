<?php
include 'db_connect.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

// Les réponses de l'utilisateur, probablement envoyées via AJAX
$userResponses = $_POST['userResponses']; // ['Réponse1', 'Réponse2', ...]
$qcmId = $_POST['qcmId']; // L'identifiant du QCM


// Récupérer toutes les bonnes réponses pour le qcmId donné
$stmt = $conn->prepare("SELECT bonneRep FROM feur WHERE qcmId = ? ORDER BY id ASC"); // Assumer que vous avez un champ 'id' pour ordonner ou un autre critère d'ordre
$stmt->bind_param("i", $qcmId);
$stmt->execute();
$result = $stmt->get_result();

$correctAnswers = [];
while ($row = $result->fetch_assoc()) {
    $correctAnswers[] = $row['bonneRep'];
}

// Comparer les réponses de l'utilisateur avec les réponses correctes
foreach ($userResponses as $index => $userResponse) {
    if (isset($correctAnswers[$index])) {
        // Compare la réponse de l'utilisateur avec la réponse correcte à l'index correspondant
        if ($correctAnswers[$index] == $userResponse) {
            echo "Réponse à la question " . ($index + 1) . " : vrai<br>";
        } else {
            echo "Réponse à la question " . ($index + 1) . " : faux<br>";
        }
    } else {
        echo "Pas de réponse correcte trouvée pour la question " . ($index + 1) . "<br>";
    }
}

$stmt->close();
$conn->close();



/*$sql = "SELECT * FROM feur WHERE id = 1 AND bonneRep ='$question1'";

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
*/

echo json_encode($responseData);
