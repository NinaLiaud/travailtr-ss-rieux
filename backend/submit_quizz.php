<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    // Collecte des data du form
    $question = htmlspecialchars($_REQUEST['question']);
    $A = htmlspecialchars($_REQUEST['A']);
    $B = htmlspecialchars($_REQUEST['B']);
    $C = htmlspecialchars($_REQUEST['C']);
    $D = htmlspecialchars($_REQUEST['D']);
    $bonneRep = htmlspecialchars($_REQUEST['bonneRep']);


    if (empty($bonneRep)) {
        echo "Informations incomplètes";
    } else {
        $sql = "INSERT INTO feur (question, A, B, C, D, bonneRep) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $question, $A, $B, $C, $D, $bonneRep);

        if ($stmt->execute()) {
            echo "<p>Enregistrement réussi!</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
