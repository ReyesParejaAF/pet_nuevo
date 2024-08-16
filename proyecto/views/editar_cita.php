<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Cita</title>
  <link rel="stylesheet" href="assets/andres/styles/admin.css">
  <?php include 'partials/header.php'?>
  <style>
    #message {
      color: green;
      font-weight: bold;
      text-align: center;
      font-size: 1.4em; 
      margin-bottom: 20px; 
      font-family: 'Times New Roman', Times, serif; 
    }
  </style>
</head>
<body>
  <div class="citas1">
    <label for="aviso">
      <h3>Editar Cita:</h3>
    </label>

    <div id="message"></div>

    <form id="citaForm" action="index.php?controller=FormularioController&action=edit" method="POST" onsubmit="return validarFormulario()">
      <input type="hidden" name="id_cita" value="<?php echo htmlspecialchars($cita['id_cita']); ?>">

      <label for="nombre">Nombre del propietario:*</label>
      <input type="text" name="name" id="nombre" value="<?php echo htmlspecialchars($cita['nombre_propietario']); ?>" required>

      <label for="contacto">Numero de contacto:*</label>
      <input type="tel" name="tel" id="contacto" value="<?php echo htmlspecialchars($cita['numero_contacto']); ?>" required>

      <label for="nmascota">Nombre de la mascota:</label>
      <input type="text" name="mascota" id="nmascota" value="<?php echo htmlspecialchars($cita['nombre_mascota']); ?>">

      <label for="rmascota">Raza de la mascota:*</label>
      <input type="text" name="razamascota" id="rmascota" value="<?php echo htmlspecialchars($cita['raza_mascota']); ?>" required>

      <label for="servicio">Servicio:*</label>
      <input type="text" name="servicio" id="servicio" value="<?php echo htmlspecialchars($cita['servicio']); ?>" required>

      <label for="fecha">Fecha de la cita:*</label>
      <input type="date" name="fecha" id="fecha" value="<?php echo htmlspecialchars($cita['fecha_cita']); ?>" oninput="validarFecha()" required><br><br>

      <label for="hora">Hora de la cita:*</label>
      <input type="time" name="hora" id="hora" value="<?php echo htmlspecialchars($cita['hora_cita']); ?>" required>

      <br><br>

      <input type="submit" value="Actualizar">
    </form>

    <script>
      function validarFormulario() {
        var nombre = document.getElementById('nombre').value.trim();
        var contacto = document.getElementById('contacto').value.trim();
        var rmascota = document.getElementById('rmascota').value.trim();
        var servicio = document.getElementById('servicio').value.trim();
        var fecha = document.getElementById('fecha').value;
        var hora = document.getElementById('hora').value;

        if (nombre === '' || contacto === '' || rmascota === '' || servicio === '' || fecha === '' || hora === '') {
          alert('Por favor, complete los campos obligatorios (*) para proceder al envío.');
          return false;
        }

        var today = new Date().toISOString().split('T')[0];
        if (fecha < today) {
          alert('Seleccione una fecha futura para la cita.');
          return false;
        }

        return true;
      }

      function validarFecha() {
        var fecha = document.getElementById('fecha').value;
        var today = new Date().toISOString().split('T')[0];

        if (fecha < today) {
          alert('Seleccione una fecha futura para la cita.');
        }
      }
    </script>
  </div>
</body>
</html>
