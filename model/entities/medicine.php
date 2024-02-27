<?php

namespace Model;

class Medicine {
    private $id;
    private $name;
    private $dosage;
    private $form;
    private $recipeId;
    private $recovered;

    public function getId() {
        return $this->id;
    }
    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getName() {
        return $this->name;
    }
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function getDosage() {
        return $this->dosage;
    }
    public function setDosage($dosage) {
        $this->dosage = $dosage;
        return $this;
    }

    public function getForm() {
        return $this->form;
    }
    public function setForm($form) {
        $this->form = $form;
        return $this;
    }

    public function getRecipeId() {
        return $this->recipeId;
    }
    public function setRecipeId($recipeId) {
        $this->recipeId = $recipeId;
        return $this;
    }

    public function getRecovered() {
        return $this->recovered;
    }
    public function setRecovered($recovered) {
        if ($recovered == 'on') $recovered = '1';
        $this->recovered = $recovered;
        return $this;
    }
}
?>