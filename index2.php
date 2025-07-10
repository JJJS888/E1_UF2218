<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Instancia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      margin: 2rem;
      font-family: 'Segoe UI', sans-serif;
    }
    .instancia {
      border: 2px solid #34495e;
      padding: 2rem 2.5rem;
      border-radius: 10px;
      max-width: 850px;
      margin: 3rem auto;
      position: relative;
      background-color: #f9fcff;
    }
    .titulo {
      text-align: center;
      font-size: 1.6rem;
      margin-bottom: 2rem;
      font-weight: bold;
    }
    .contenido {
      font-size: 1.1rem;
      line-height: 1.6;
    }
    .fecha {
      position: absolute;
      top: 15px;
      right: 30px;
      font-weight: bold;
      font-size: 0.95rem;
      color: #34495e;
    }
    .firmar {
      text-align: right;
      margin-top: 3rem;
      font-style: italic;
    }
  </style>
</head>
<body>

<?php
  date_default_timezone_set("Europe/Lisbon");
  $fechaActual = date("d/m/Y");

  function limpiar($campo) {
    return htmlspecialchars($_GET[$campo] ?? '');
  }

  $nombre   = limpiar("nombre");
  $apellido = limpiar("apellido");
  $email    = limpiar("email");
  $dni      = strtoupper(limpiar("dni"));

  // Formatear DNI tipo 00.000.000.F
  if (preg_match('/^(\d{8})([A-Z])$/', str_replace(['-', '.', ' '], '', $dni), $m)) {
    $dni = substr($m[1], 0, 2) . '.' . substr($m[1], 2, 3) . '.' . substr($m[1], 5, 3) . '.' . $m[2];
  }
?>

<div class="instancia">
  <div class="fecha">Fecha: <?= $fechaActual ?></div>

  <div class="titulo">Instancia</div>

  <div class="contenido">
    <?= $nombre ?: '[nombre]' ?> <?= $apellido ?: '[apellido]' ?> con DNI <?= $dni ?: '[dni]' ?> y correo electrónico <?= $email ?: '[email]' ?>
    
    <br><br>
    <strong>Expone:</strong><br>
  
    <br>
    <strong>Solicita:</strong><br>
  

   
  </div>
</div>
<div class="text-center mt-4">
  <a href="index.html" class="btn btn-info">🔙 Volver al formulario</a>
</div>

</body>
</html>
