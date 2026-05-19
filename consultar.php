<?php
require_once 'conexion.php';

$resultados = [];
$matricula = "";
$busqueda_realizada = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['matricula_busqueda'])) {
    $matricula = trim($_POST['matricula_busqueda']);
    $busqueda_realizada = true;

    try {
        // CORRECCIÓN: Buscamos en la columna 'MatriculaAlumno'
        $sql = "SELECT * FROM datosprestamo WHERE MatriculaAlumno = ? ORDER BY FechaInicioLectura DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$matricula]);
        $resultados = $stmt->fetchAll();
    } catch (\PDOException $e) {
        die("Error crítico en la consulta: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Resultados de Consulta</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>
  <header class="header-titulo">
    <h1>Resultados de Búsqueda</h1>
  </header>

  <main class="main-principal" style="max-width: 850px;">
    <div class="card1" style="background-color: var(--navy);">
      
      <h2 style="color: var(--yellow); font-family: 'Fredoka One', cursive;">
        Matrícula: <?php echo htmlspecialchars($matricula); ?>
      </h2>
      
      <?php if ($busqueda_realizada && !empty($resultados)): ?>
        <p class="texto-info" style="text-align: left; width: 100%; font-weight: 700; color: var(--blue-light); border-bottom: 2px dashed rgba(255,255,255,0.2); padding-bottom: 8px;">
          Alumno: <?php echo htmlspecialchars($resultados[0]['NombreAlumno']); ?> <br>
          Especialidad: <?php echo htmlspecialchars($resultados[0]['Especialidad']); ?> | Semestre: <?php echo htmlspecialchars($resultados[0]['Semestre']); ?>°
        </p>
        
        <div class="tabla-contenedor">
          <table class="tabla-resultados">
            <thead>
              <tr>
                <th>Código de Libro</th>
                <th>Título del Libro</th>
                <th>Fecha Inicio</th>
                <th>Fecha Término</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($resultados as $fila): ?>
                <tr>
                  <td><strong><?php echo htmlspecialchars($fila['CodigoLibro']); ?></strong></td>
                  <td><?php echo htmlspecialchars($fila['NombreLibro']); ?></td>
                  <td><?php echo htmlspecialchars($fila['FechaInicioLectura']); ?></td>
                  <td><?php echo htmlspecialchars($fila['FechaTerminoLectura']); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <p class="texto-info" style="margin: 30px 0; color: var(--yellow-dark); font-weight: bold;">
          ⚠️ No se localizaron bitácoras o lecturas activas asociadas a la matrícula proporcionada.
        </p>
      <?php endif; ?>

      <button class="btn2" onclick="window.location.href='principal.html'" style="margin-top: 15px; background-color: var(--blue-mid); color: white; max-width: 250px;">
        🔍 Nueva Búsqueda
      </button>
    </div>
  </main>
</body>
</html>