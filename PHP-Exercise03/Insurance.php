<?php
require_once 'PatientRecord.php';

class Insurance implements PatientRecord {
    private $_id;
    private $patient_id;
    private $iname;
    private $from_date;
    private $to_date;

    public function __construct($id, $patient_id, $iname, $from_date, $to_date) {
        $this->_id = $id;
        $this->patient_id = $patient_id;
        $this->iname = $iname;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
    }

    public function getId() {
        return $this->_id;
    }

    public function getPatientNumber() {
        $patientId = $this->patient_id;
    
        // Fetch the patient number from the database using the patient_id
        $query = "SELECT pn FROM patients WHERE _id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['pn']; 
        } else {
            return "Unknown"; 
        }
    }

    public function isValidOnDate($compareDate) {
        // Convert compareDate to the format of from_date and to_date for easy comparison
        $compareDate = date('Y-m-d', strtotime($compareDate));
        $fromDate = date('Y-m-d', strtotime($this->from_date));
        $toDate = $this->to_date ? date('Y-m-d', strtotime($this->to_date)) : null;

        // Check if compareDate falls within the from_date and to_date (if to_date is not null)
        if ($toDate) {
            return ($compareDate >= $fromDate && $compareDate <= $toDate);
        } else {
            // If to_date is not defined, consider the insurance to be effective infinitely
            return ($compareDate >= $fromDate);
        }
    }

    public function getInsuranceName() {
        return $this->iname;
    }
}
