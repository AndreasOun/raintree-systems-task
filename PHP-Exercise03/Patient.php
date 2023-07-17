<?php
require_once 'PatientRecord.php';
require_once 'Insurance.php';

class Patient implements PatientRecord {
    private $_id;
    private $pn;
    private $first;
    private $last;
    private $dob;
    private $insurances = [];

    public function __construct($pn, $first, $last, $dob) {
        $this->pn = $pn;
        $this->first = $first;
        $this->last = $last;
        $this->dob = $dob;
    }

    public function getId() {
        return $this->_id;
    }

    public function getPatientNumber() {
        return $this->pn;
    }

    public function getFullName() {
        return $this->first . ' ' . $this->last;
    }

    public function addInsurance(Insurance $insurance) {
        $this->insurances[] = $insurance;
    }

    public function getInsurances() {
        return $this->insurances;
    }

    public function printTableByDate($compareDate) {
        echo "Patient Number, First Last, Insurance name, Is Valid" . PHP_EOL;
        foreach ($this->insurances as $insurance) {
            $isValid = $insurance->isValidOnDate($compareDate) ? 'Yes' : 'No';
            echo $this->pn . ", " . $this->getFullName() . ", " . $insurance->getInsuranceName() . ", " . $isValid . PHP_EOL;
        }
    }
}
