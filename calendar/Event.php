

<?php

  class Event {

    private $id;

    private $nom;

    private $description;

    private $debut;

    private $fin;

    private $jour_recurrent;

    private $fin_jour_recurrent;

    private $validated;

    public function getId(): int {
      return $this->id;
    }

    public function getName(): string {
      return $this->nom;
    }

    public function getDescription(): string {
      return $this->description ?? '';
    }

    public function getStart(): DateTime {
      return new DateTime($this->debut);
    }

    public function getEnd(): DateTime {
      return new DateTime($this->fin);
    }

    public function getLoop(): string {
      return $this->jour_recurrent;
    }

    public function getEndLoop(): DateTime {
      return new DateTime($this->fin_jour_recurrent);
    }


    public function setName(string $nom) {
      $this->nom = $nom;
    }

    public function setDescription(string $description) {
      $this->description = $description;
    }

    public function setStart(string $debut) {
      $this->debut = $debut;
    }

    public function setEnd(string $fin) {
      $this->fin = $fin;
    }

    public function setLoop(string $jour_recurrent) {
      $this->jour_recurrent = $jour_recurrent;
    }

    public function setEndLoop(string $fin_jour_recurrent) {
      $this->fin_jour_recurrent = $fin_jour_recurrent;
    }

    public function setValidateEvent() {
      $this->validated = 0;
    }


    public function toString(): string {
      return "Nom: ".$this->nom."<br>Description: ".$this->description."<br>Début: ".$this->debut."<br>Fin: ".$this->fin."<br>Récurrence le: ".$this->jour_recurrent."<br>Fin récurence: ".$this->fin_jour_recurrent;
    }

  }

?>
