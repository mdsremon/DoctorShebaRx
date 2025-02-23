<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["patient_name"], $data["medication"], $data["dosage"], $data["frequency"], $data["doctor_signature"])) {
    $stmt = $conn->prepare("INSERT INTO prescriptions (patient_name, medication, dosage, frequency, doctor_signature) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data["patient_name"], $data["medication"], $data["dosage"], $data["frequency"], $data["doctor_signature"]);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Prescription added successfully"]);
    } else {
        echo json_encode(["error" => "Failed to add prescription"]);
    }
} else {
    echo json_encode(["error" => "Invalid data"]);
}
?>
