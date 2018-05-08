<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Minimización</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" media="screen" href="css/main.css" />
  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/main.js"></script>
</head>
<body>
  <form id="form" action="minimize.php" method="post">
    <div id="numbers" class="card">
      <div class="input-field">
        <label for="entriesNumber">Número de entradas:</label>
        <input id="entriesNumber" name="entriesNumber" type="text">
      </div>
      <div class="input-field">
        <label for="statesNumber">Número de estados:</label>
        <input id="statesNumber" name="statesNumber" type="text">
      </div>
    </div>

    <div id="tableContainer" class="card">
      <h4>Tabla de transiciones:</h4>
      <table id="tt">
        <thead>
          <tr>
            <th>Estados</th>
            <th>Inicial</th>
            <th>Final</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>
      <button type="submit">Minimizar</button>
    </div>
  </form>

  <div id="answer" style="display: none;" class="card">
    <h4>Autómata minimizado</h5>
    <h5>Tabla de transiciones:</h4>
    <form id="answerForm" action="#" method="post">
      <table id="ttAnswer">
        <thead>
          <tr>
            <th>Estados</th>
            <th>Inicial</th>
            <th>Final</th>
          </tr>
        </thead>
        <tbody>
  
        </tbody>
      </table>
    </form>
  </div>
</body>
</html>