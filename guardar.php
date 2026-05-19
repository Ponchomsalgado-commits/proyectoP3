<?php 
require_once 'conexion.php';

$mensaje = "";
$clase_alerta = "color: var(--yellow);";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibimos los datos del formulario de principal.html
    $matricula_alumno = $_POST['matricula_alumno']; 
    $nombre           = $_POST['nombre_alumno'];
    $semestre         = $_POST['semestre'];
    $especialidad     = $_POST['especialidad'];
    $codigo           = $_POST['codigo_libro'];
    $nombre_libro     = $_POST['nombre_libro'];
    $fecha_inicio     = $_POST['fecha_inicio_lecutura']; 
    $fecha_final      = $_POST['fecha_final_lecutura'];

    try {
        // AQUI ESTÁ LA CORRECCIÓN: Nombres exactos de las columnas de tu imagen
        $sql = "INSERT INTO datosprestamo (MatriculaAlumno, NombreAlumno, Semestre, Especialidad, CodigoLibro, NombreLibro, FechaInicioLectura, FechaTerminoLectura) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matricula_alumno, $nombre, $semestre, $especialidad, $codigo, $nombre_libro, $fecha_inicio, $fecha_final]);
        
        $mensaje = "El registro de lectura se ha guardado de manera exitosa en la base de datos.";
        $clase_alerta = "color: var(--green);";
    } catch (\PDOException $e) {
        $mensaje = "Error al guardar: " . $e->getMessage();
        $clase_alerta = "color: var(--yellow-dark);";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Estado del Registro</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <div class="card1" style="max-width: 500px; margin-top: 80px; text-align: center;">
    <h2 style="<?php echo $clase_alerta; ?> font-family: 'Fredoka One', cursive;">Estado del Servidor</h2>
    <p class="texto-info" style="margin: 15px 0; font-weight: 600;"><?php echo $mensaje; ?></p>
    <button class="btn2" onclick="window.location.href='principal.html'" style="margin-top: 10px; background-color: var(--white); max-width: 100%;">
      Volver al Panel
    </button>
  </div>
</body>
</html>