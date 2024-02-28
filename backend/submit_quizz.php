<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'db_connect.php';
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    
    $bonneRep = htmlspecialchars($_REQUEST['bonneRep']);
    $qcmId = htmlspecialchars($_REQUEST['qcmId']);

    if (empty($bonneRep)) {
        echo "Informations incomplètes";
    } else {
        
        $sql = "INSERT INTO feur (bonneRep, qcmId) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        
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
