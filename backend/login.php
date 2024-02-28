<?php
include 'db_connect.php';
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');


$userResponses = $_POST['userResponses']; 
$qcmId = $_POST['qcmId']; 



$stmt = $conn->prepare("SELECT bonneRep FROM feur WHERE qcmId = ? ORDER BY id ASC");
$stmt->bind_param("i", $qcmId);
$stmt->execute();
$result = $stmt->get_result();

$correctAnswers = [];
while ($row = $result->fetch_assoc()) {
    $correctAnswers[] = $row['bonneRep'];
}


foreach ($userResponses as $index => $userResponse) {
    if (isset($correctAnswers[$index])) {
        
        if ($correctAnswers[$index] == $userResponse) {
            echo "vrai<br>";
        } else {
            echo "faux<br>";
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
