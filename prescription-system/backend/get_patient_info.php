<?php
include "config.php";

if (isset($_GET["patient_name"])) {
    $patient_name = $_GET["patient_name"];

    $stmt = $conn->prepare("SELECT * FROM prescriptions WHERE patient_name = ? ORDER BY date_created DESC LIMIT 1");
    $stmt->bind_param("s", $patient_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode($row);
    } else {
        echo json_encode(["error" => "Patient not found"]);
    }
} else {
    echo json_encode(["error" => "Invalid request"]);
}
?>
