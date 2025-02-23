<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body { background: #f8f9fa; }
        .container { max-width: 800px; margin-top: 20px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0,0,0,0.1); }
        h1 { font-size: 22px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Prescription System</h1>

        <form id="prescriptionForm">
            <!-- Patient Details -->
            <div class="mb-3">
                <label>Patient Name:</label>
                <input type="text" id="patient_name" name="patient_name" class="form-control" required>
            </div>
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label>Age:</label>
                    <input type="number" id="age" name="age" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Weight (kg):</label>
                    <input type="number" id="weight" name="weight" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label>Gender:</label>
                    <select id="gender" name="gender" class="form-control">
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Phone Number:</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Registration No:</label>
                    <input type="text" id="registration_no" name="registration_no" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label>Address:</label>
                <textarea id="address" name="address" class="form-control" required></textarea>
            </div>

            <!-- Medications Section -->
            <h3>Medications</h3>
            <div id="medications-list">
                <div class="row medication-row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="medication[]" class="form-control" placeholder="Medication" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="dosage[]" class="form-control" placeholder="Dosage" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="frequency[]" class="form-control" placeholder="Frequency" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-danger remove-medication">X</button>
                    </div>
                </div>
            </div>
            <button type="button" id="addMedication" class="btn btn-secondary mb-3">+ Add Medication</button>

            <div class="mb-3">
                <label>Additional Notes:</label>
                <textarea name="additional_notes" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100">Save Prescription</button>
        </form>
    </div>

    <script>
        // Auto-fill patient details when name is selected
        $("#patient_name").change(function() {
            let patientName = $(this).val();
            $.getJSON("backend/get_patient_info.php", { patient_name: patientName }, function(data) {
                if (!data.error) {
                    $("#age").val(data.age);
                    $("#weight").val(data.weight);
                    $("#gender").val(data.gender);
                    $("#phone_number").val(data.phone_number);
                    $("#registration_no").val(data.registration_no);
                    $("#address").val(data.address);
                }
            });
        });

        // Handle form submission (Save Prescription)
        $("#prescriptionForm").submit(function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            $.ajax({
                url: "backend/save_prescription.php",
                method: "POST",
                contentType: "application/json",
                data: JSON.stringify(Object.fromEntries(formData)),
                success: function(response) {
                    alert(response.message || response.error);
                }
            });
        });

        // Add new medication fields dynamically
        $("#addMedication").click(function() {
            $("#medications-list").append(`
                <div class="row medication-row">
                    <div class="col-md-4 mb-3">
                        <input type="text" name="medication[]" class="form-control" placeholder="Medication" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="dosage[]" class="form-control" placeholder="Dosage" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <input type="text" name="frequency[]" class="form-control" placeholder="Frequency" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <button type="button" class="btn btn-danger remove-medication">X</button>
                    </div>
                </div>
            `);
        });

        // Remove medication row
        $(document).on("click", ".remove-medication", function() {
            $(this).closest(".medication-row").remove();
        });
    </script>
</body>
</html>
