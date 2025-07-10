<?php
$conexion = new mysqli("localhost", "root", "", "instancia");
if ($conexion->connect_error) {
  die("Error de conexión: " . $conexion->connect_error);
}

// Función para limpiar espacios y escapar valores
function limpiar($valor) {
  global $conexion;
  return $conexion->real_escape_string(trim($valor));
}

// Obtener datos del formulario
$nombre   = limpiar($_GET["nombre"] ?? '');
$apellido = limpiar($_GET["apellido"] ?? '');
$dni      = limpiar($_GET["dni"] ?? '');
$email    = limpiar($_GET["email"] ?? '');

// Validación básica de campos vacíos
if (!$nombre || !$apellido || !$dni || !$email) {
  die("<h3 style='color:red; text-align:center;'>Todos los campos son obligatorios.</h3>");
}

// Consulta SQL con normalización
$sql = "SELECT * FROM datos WHERE LOWER(TRIM(dni)) = LOWER(TRIM('$dni'))";
$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
  $fila = $resultado->fetch_assoc();

  // Comparar cada campo con flexibilidad
  function comparar($a, $b) {
    return strtolower(trim($a)) === strtolower(trim($b));
  }

  $fallos = [];

  if (!comparar($nombre, $fila['nombre'])) {
    $fallos[] = "❌ El nombre no coincide: enviado <strong>'$nombre'</strong>, esperado <strong>'{$fila['nombre']}'</strong>";
  }

  if (!comparar($apellido, $fila['apellido'])) {
    $fallos[] = "❌ El apellido no coincide: enviado <strong>'$apellido'</strong>, esperado <strong>'{$fila['apellido']}'</strong>";
  }

  if (!comparar($email, $fila['email'])) {
    $fallos[] = "❌ El email no coincide: enviado <strong>'$email'</strong>, esperado <strong>'{$fila['email']}'</strong>";
  }

  // Si no hay errores, redirige
  if (empty($fallos)) {
    header("Location: index2.php?nombre=$nombre&apellido=$apellido&dni=$dni&email=$email");
    exit;
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Validación fallida</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <div class="alert alert-danger text-center">
      <h4>⚠️ Los datos no son válidos</h4>
      <?php
        // Mostrar errores si hay comparación fallida
        if (!empty($fallos)) {
          echo "<ul class='list-unstyled'>";
          foreach ($fallos as $f) {
            echo "<li>$f</li>";
          }
          echo "</ul>";
        } else {
          echo "❌ El DNI <strong>'$dni'</strong> no está registrado en la base de datos.";
        }
      ?>
    </div>
    <div class="text-center">
      <a href="index.html" class="btn btn-secondary">🔙 Volver al formulario</a>
    </div>
  </div>
</body>
</html>
