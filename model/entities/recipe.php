<?php

namespace Model;

class Recipe {
    private $id;
    private $patient;
    private $born;
    private $doctor;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    public function getPatient() {
        return $this->patient;
    }
    public function setPatient($patient) {
        $this->patient = $patient;
        return $this;
    }
    
    public function getBorn() {
        return $this->born;
    }
    public function setBorn($born) {
        $this->born = $born;
        return $this;
    }
    
    public function getDoctor() {
        return $this->doctor;
    }
    public function setDoctor($doctor) {
        $this->doctor = $doctor;
        return $this;
    }
}
?>

