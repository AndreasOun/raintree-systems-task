<?php
// Connect to the database
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'database01';

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Execute the query to fetch data
$query = "SELECT p.pn, p.last, p.first, i.iname, DATE_FORMAT(i.from_date, '%m-%d-%y') AS from_date, DATE_FORMAT(i.to_date, '%m-%d-%y') AS to_date
          FROM patient p
          JOIN insurance i ON p._id = i.patient_id
          ORDER BY i.from_date ASC, p.last ASC";

$result = $conn->query($query);

// Check if there are any results
if ($result->num_rows > 0) {
    // Loop through the results and display them
    while ($row = $result->fetch_assoc()) {
        echo $row['pn'] . ", " . $row['last'] . ", " . $row['first'] . ", " . $row['iname'] . ", " . $row['from_date'] . ", " . $row['to_date'] . "\n";
    }
} else {
    echo "No records found.\n";
}

// Get all first and last names
$namesQuery = "SELECT first, last FROM patient";
$namesResult = $conn->query($namesQuery);

// Initialize an array to store letter counts
$letterCounts = [];

// Make a loop to loop through the names
while ($nameRow = $namesResult->fetch_assoc()) {
    // Check first and last names
    $fullName = $nameRow['first'] . " " . $nameRow['last'];

    // Count occurrences of each letter
    $letters = preg_replace("/[^a-zA-Z]/", "", $fullName);
    $letters = strtolower($letters);
    $letterArray = str_split($letters);

    foreach ($letterArray as $letter) {
        if (isset($letterCounts[$letter])) {
            $letterCounts[$letter]++;
        } else {
            $letterCounts[$letter] = 1;
        }
    }
}

// Sort the letter counts array alphabetically
ksort($letterCounts);

// Calculate total number of letters
$totalLetters = array_sum($letterCounts);

// Display the letter statistics
foreach ($letterCounts as $letter => $count) {
    $percentage = ($count / $totalLetters) * 100;
    echo strtoupper($letter) . "\t" . $count . "\t" . number_format($percentage, 2) . " %\n";
}

// Close database connection
$conn->close();
