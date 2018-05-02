<?php
  class State{
    public $initial = false;
    public $final = false;
    public $name;
    public $transitions = array();
    
    function __construct($name){
      $this->name = $name;
    }

    public function getName(){
      return $this->name;
    }

    public function isFinal(){
      return $this->final;
    }

    public function isInitial(){
      return $this->initial;
    }

    public function setName($name){
      $this->name = $name; 
    }
 
    public function addTransition($stateName){
      array_push($this->transitions, $stateName);
    }

    public function getTransitions(){
      return $this->transitions;
    }
    
    public function setFinal($final){
      $this->final = $final;
    }
    
    public function setInitial($initial){
      $this->initial = $initial;
    }

    public function showState(){
      echo '<pre>';
      echo 'name: ';
      echo var_dump($this->name);
      echo '<br>';
      echo 'final: ';
      echo var_dump($this->final);
      echo '<br>';
      echo 'initial';
      echo var_dump($this->initial);
      echo '</pre>';
    }
  }
?>