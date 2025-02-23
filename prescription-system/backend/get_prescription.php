<?php
include "config.php";

$sql = "SELECT * FROM prescriptions";
$result = $conn->query($sql);

$prescriptions = [];
while ($row = $result->fetch_assoc()) {
    $prescriptions[] = $row;
}

header("Content-Type: application/json");
echo json_encode($prescriptions);
?>
