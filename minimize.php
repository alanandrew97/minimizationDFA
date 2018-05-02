<?php
  include 'State.php';

  $request = $_POST;
  $groups = array();

  // printArray($request['states']);

  
  //Crear matriz de estados
  $states = [];
  foreach ($request['states'] as $i => $stateArray) {
    $state = new State($i);
    if(isset($stateArray['initial'])){
      $state->setInitial(true);
    }
    if(isset($stateArray['final'])){
      $state->setFinal(true);
    }
    array_push($states, $state);
    // printArray($stateArray);
    
    //Agregar transiciones al estado
    if ($state->isInitial() && $state->isFinal()) {
      for ($j=0; $j < count($stateArray)-2; $j++) {
        $state->addTransition($stateArray[$j]);
      }
    } else if ($state->isInitial() || $state->isFinal()){
      for ($j=0; $j < count($stateArray)-1; $j++) { 
        $state->addTransition($stateArray[$j]);
      }
    } else {
      for ($j=0; $j < count($stateArray); $j++) { 
        $state->addTransition($stateArray[$j]);
      }
    }
    
  }
  printArray($states);

  //Dividir en finales y no finales
  $final = array();
  $notFinal = array();
  foreach ($states as $i => $state) {
    if ($state->isFinal()) {
      array_push($final, $state->name);
    } else {
      array_push($notFinal, $state->name);
    }
  }


  function printArray($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }

?>