

<?php

  include("Validator.php");

  class EventValidator extends Validator {



    public function validateAll(array $data) {

      parent::validates($data);
      $this->validate("name-event", "minlength", 3);
      $this->validate("date-event", "date");
      $this->validate("start-event", "startBeforeEnd", "end-event");
      $this->validate("date-event", "startBeforeEndLoop", "endLoop-event");

      return $this->errors;
    }


  }

?>
