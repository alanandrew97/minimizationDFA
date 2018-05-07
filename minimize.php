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

  echo 'Final: ';
  printArray($final);
  echo 'No final: ';
  printArray($notFinal);

  array_push( $groups, $notFinal );
  array_push( $groups, $final );

  echo "GROUPS";
  printArray($groups);

  // Separacion en grupos--------------------------------------------------
  do {
    printArray(var_dump(isset($newGroups)));
    if ( isset($newGroups) ) $groups = $newGroups;
    $newGroups = array();
    
    // Estados no finales
    $notFinalTransitions = array();
    foreach ($states as $i => $state) {
      $notFinalTransition = '';
      if ( !$state->isFinal() ) {
        for ($j=0; $j < count($state->transitions); $j++) {
          for ($k=0; $k < count($groups); $k++) { 
            if( in_array($state->transitions[$j], $groups[$k]) ) {
              $notFinalTransition = $notFinalTransition.strval($k);
            }
          }
        }
      }
      if ($notFinalTransition != '') {
        $state->setGroups($notFinalTransition);
        array_push($notFinalTransitions, $notFinalTransition);
      }
    }
  
    echo "Transiciones no finales totales por estado";
    printArray($notFinalTransitions);
    $uniqueNotFinalTransitions = array_unique($notFinalTransitions);
    $uniqueNotFinalTransitionsAux = array();
    foreach ($uniqueNotFinalTransitions as $i => $uniqueNotFinalTransition) {
      array_push($uniqueNotFinalTransitionsAux, $uniqueNotFinalTransition);
    }
    $uniqueNotFinalTransitions = $uniqueNotFinalTransitionsAux;
    //Transiciones x las cuales se creara un grupo
    echo "Transiciones no finales unicas por estado";
    printArray($uniqueNotFinalTransitions);
    
    //Inicializar nuevos grupos
    for ($i=0; $i < count($uniqueNotFinalTransitions); $i++) { 
      $newGroups[$i] = array();
    }
  
    // Estados finales
    $finalTransitions = array();
    foreach ($states as $i => $state) {
      $finalTransition = '';
      if ( $state->isFinal() ) {
        for ($j=0; $j < count($state->transitions); $j++) {
          for ($k=0; $k < count($groups); $k++) { 
            if( in_array($state->transitions[$j], $groups[$k]) ) {
              $finalTransition = $finalTransition.strval($k);
            }
          }
        }
      }
      if ($finalTransition != '') {
        $state->setGroups($finalTransition);      
        array_push($finalTransitions, $finalTransition);
      }
    }
              
    echo "Transiciones finales totales por estado";
    printArray($finalTransitions);
    $uniqueFinalTransitions = array_unique($finalTransitions);
    $uniqueFinalTransitionsAux = array();
    foreach ($uniqueFinalTransitions as $i => $uniqueFinalTransition) {
      array_push($uniqueFinalTransitionsAux, $uniqueFinalTransition);
    }
    $uniqueFinalTransitions = $uniqueFinalTransitionsAux;
    //Transiciones x las cuales se creara un grupo
    echo "Transiciones finales unicas por estado";
    printArray($uniqueFinalTransitions);
  
    //Inicializar nuevos grupos
    for ($i=0; $i < count($uniqueFinalTransitions); $i++) { 
      $j = $i + count($uniqueNotFinalTransitions);
      $newGroups[$j] = array();
    }
  
    
    //Asigna cada estado a el nuevo grupo
    foreach ($states as  $state) {
      $stringTransitions = $state->getGroups();
      // printArray($stringTransitions);
      if ( !$state->isFinal() ) {
        for ($i=0; $i < count($uniqueNotFinalTransitions); $i++) { 
          if ($stringTransitions == $uniqueNotFinalTransitions[$i]) {
            array_push($newGroups[$i], $state->name);
          }
        }
      }
      if ( $state->isFinal() ) {
        for ($i=0; $i < count($uniqueFinalTransitions); $i++) { 
          if ($stringTransitions == $uniqueFinalTransitions[$i]) {
            $j = $i + count($uniqueNotFinalTransitions);
            array_push($newGroups[$j], $state->name);
          }
        }
      }
    }
  
    echo "newGorups";
    printArray( $newGroups );
  
  } while ($groups != $newGroups);

  // printArray(count($newGroups));

  //Crear array con los estados que seran cancelados y por cual serán
  // reemplazados
  $statesToCancel = array();
  foreach ($newGroups as $j => $group) {
    foreach ($group as $i => $stateName) {
      if ($i == 0) {
        $stateToSurvive = $stateName;
      } else {
        $statesToCancel[$stateName] = $stateToSurvive;
      }
    }
  }

  printArray("Estados a cancelar");
  printArray($statesToCancel);

  $newStates = array();

  foreach ($states as $i => $state) {
    if(array_key_exists($state->name, $statesToCancel)) unset($states[$i]);
  }

  $statesAux = array();
  $c = 0;
  foreach ($states as $state) {
    $state->setName($c);
    array_push($statesAux, $state);
    $c++;
  }

  $statesToRename = array();
  foreach ($states as $i => $state) {
    if ($i != $state->name) {
      $statesToRename[$i] = $state->name;
    }
  }
  
  $states = $statesAux;
  printArray($states);


  $counter = 0;
  foreach ($states as $state) {
    // if(array_key_exists($state->name, $statesToCancel)) printArray("Estado eliminado");
    // else {
      $newState = new State($counter);
      $newState->setInitial( $state->isInitial() );
      $newState->setFinal( $state->isFinal() );
      foreach ($state->transitions as $transition) {
        if(array_key_exists($transition, $statesToCancel)) {
          $newState->addTransition($statesToCancel[$transition]);
        } else  if(array_key_exists($transition, $statesToRename)) {
          $newState->addTransition($statesToRename[$transition]);
        } else $newState->addTransition($transition);
      }
      $counter++;
      array_push($newStates, $newState);
    // }
  }

  printArray($newStates);

  return json_encode($newStates);



  function printArray($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }

?>