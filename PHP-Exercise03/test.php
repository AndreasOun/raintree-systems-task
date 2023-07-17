<?php
require_once 'Patient.php';

// Database connection parameters
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'database01';

// Connection to the database
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Fetch patient data from the database
$patientQuery = "SELECT * FROM patient";
$patientResult = $conn->query($patientQuery);

// Array to store patient objects
$patients = [];

// Loop through the results and create Patient objects
while ($patientRow = $patientResult->fetch_assoc()) {
    $patient = new Patient($patientRow['pn'], $patientRow['first'], $patientRow['last'], $patientRow['dob']);

    // Fetch insurance data for the patient from the database
    $insuranceQuery = "SELECT * FROM insurance WHERE patient_id = " . $patientRow['_id'];
    $insuranceResult = $conn->query($insuranceQuery);

    // Loop through the insurance results and create Insurance objects
    while ($insuranceRow = $insuranceResult->fetch_assoc()) {
        $insurance = new Insurance(
            $insuranceRow['_id'],
            $insuranceRow['patient_id'],
            $insuranceRow['iname'],
            $insuranceRow['from_date'],
            $insuranceRow['to_date']
        );

        // Add the Insurance object to the Patient
        $patient->addInsurance($insurance);
    }

    // Add the Patient object to the array
    $patients[] = $patient;
}

// Close database connection
$conn->close();

// Display patients and their insurances
foreach ($patients as $patient) {
    echo "Patient Number: " . $patient->getPatientNumber() . PHP_EOL;
    echo "Full Name: " . $patient->getFullName() . PHP_EOL;
    echo "Insurances:" . PHP_EOL;
    foreach ($patient->getInsurances() as $insurance) {
        echo "  - Insurance Name: " . $insurance->getInsuranceName() . PHP_EOL;
        echo "    Is Valid: " . ($insurance->isValidOnDate(date('Y-m-d')) ? 'Yes' : 'No') . PHP_EOL;
    }
    echo PHP_EOL;
}
