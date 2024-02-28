<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    // Collect data from the form
    $bonneRep = htmlspecialchars($_REQUEST['bonneRep']);
    $qcmId = htmlspecialchars($_REQUEST['qcmId']);

    if (empty($bonneRep)) {
        echo "Informations incomplètes";
    } else {
        // Fix the SQL query
        $sql = "INSERT INTO feur (bonneRep, qcmId) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        // Fix the bind_param function
        $stmt->bind_param("si", $bonneRep, $qcmId);

        if ($stmt->execute()) {
            echo "<p>Enregistrement réussi!</p>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
