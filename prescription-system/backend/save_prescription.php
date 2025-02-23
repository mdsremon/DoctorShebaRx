<?php
include "config.php";

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["patient_name"], $data["age"], $data["weight"], $data["gender"], $data["phone_number"], $data["registration_no"], $data["address"], $data["medication"], $data["dosage"], $data["frequency"], $data["additional_notes"])) {

    // Check if patient already exists
    $stmt = $conn->prepare("SELECT id FROM prescriptions WHERE patient_name = ? ORDER BY date_created DESC LIMIT 1");
    $stmt->bind_param("s", $data["patient_name"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // If patient exists, update their details
        $stmt = $conn->prepare("UPDATE prescriptions SET age=?, weight=?, gender=?, phone_number=?, registration_no=?, address=? WHERE patient_name=?");
        $stmt->bind_param("iisssss", $data["age"], $data["weight"], $data["gender"], $data["phone_number"], $data["registration_no"], $data["address"], $data["patient_name"]);
        $stmt->execute();
    } 

    // Insert prescription
    $stmt = $conn->prepare("INSERT INTO prescriptions (patient_name, age, weight, gender, phone_number, registration_no, address, medication, dosage, frequency, additional_notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siissssssss", $data["patient_name"], $data["age"], $data["weight"], $data["gender"], $data["phone_number"], $data["registration_no"], $data["address"], $data["medication"], $data["dosage"], $data["frequency"], $data["additional_notes"]);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Prescription saved successfully"]);
    } else {
        echo json_encode(["error" => "Failed to save prescription"]);
    }
} else {
    echo json_encode(["error" => "Invalid data"]);
}
?>
