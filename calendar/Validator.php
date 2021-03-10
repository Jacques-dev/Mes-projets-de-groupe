

<?php

  class Validator {

    private $data;
    protected $errors = [];

    public function __construct (array $data = []) {
      $this->data = $data;
    }

    public function validates (array $data) {
      $this->data = $data;
      $this->errors = [];
      return $this->errors;
    }

    public function validate (string $field, string $method, ...$parameters): bool {
      if (!isset($this->data[$field])) {
        $this->errors[$field] = "Le champ $field n'est pas rempli";
        return false;
      } else {
        return call_user_func([$this, $method], $field, ...$parameters);
      }
    }


    public function minLength (string $field, int $length): bool {
      if (mb_strlen($this->data[$field]) < $length) {
        $this->errors[$field] = "Le champ doit avoir plus de $length caractères.";
        return false;
      }
      return true;
    }

    public function date (string $field): bool {

      if (DateTime::createFromFormat("Y-m-d", $this->data[$field]) === false) {
        $this->errors[$field] = "La date ne semble pas valide.";
        return false;
      }

      return true;
    }

    public function time (string $field): bool {
      if (DateTime::createFromFormat("H:i", $this->data[$field]) === false) {
        $this->errors[$field] = "Le temps ne semble pas valide.";
        return false;
      }

      return true;
    }

    public function startBeforeEnd (string $startField, string $endField): bool {
      if ($this->time($startField) && $this->time($endField)) {

        $start = DateTime::createFromFormat("H:i", $this->data[$startField]);
        $end = DateTime::createFromFormat("H:i", $this->data[$endField]);

        if ($start->getTimestamp() > $end->getTimestamp()) {
          $this->errors[$startField] = "Le temps de début doit être inférieur à celui de fin.";
          return false;
        }

        if ($start->getTimestamp() == $end->getTimestamp()) {
          $this->errors[$endField] = "Le temps de fin doit être supérieur à celui de début.";
          return false;
        }

        return true;
      }

      return false;
    }

    public function startBeforeEndLoop (string $startField, string $endField): bool {

      if ($endField != null) {

        $start = DateTime::createFromFormat("Y-m-d", $this->data[$startField]);
        $end = DateTime::createFromFormat("Y-m-d", $this->data[$endField]);

        if ($start->getTimestamp() > $end->getTimestamp()) {
          $this->errors[$startField] = "Le temps de début doit être inférieur à celui de fin.";
          return false;
        }

        if ($start->getTimestamp() == $end->getTimestamp()) {
          $this->errors[$endField] = "Le temps de fin doit être supérieur à celui de début.";
          return false;
        }

        return false;
      }
    }

    public function day (string $field): bool {
      $days = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi", "Dimanche");

      foreach ($days as $day) {
        if ($field === $day) {
          return true;
        }
      }
      $this->errors[$field] = "Le jour entré n'existe pas.";
      return false;
    }


  }


?>
