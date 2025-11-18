<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function sanear_y_validar($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $errores = [];


    $nombre_completo = isset($_POST['nombre_completo']) ? sanear_y_validar($_POST['nombre_completo']) : '';
    $email = isset($_POST['email']) ? sanear_y_validar($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $password_confirm = isset($_POST['password_confirm']) ? $_POST['password_confirm'] : '';
    
    if ($password !== $password_confirm) {
        $errores[] = "Las contraseñas no coinciden. Por favor, revísalas.";
    }

    if (!isset($_POST['terminos_condiciones']) || $_POST['terminos_condiciones'] != 'si') {
        $errores[] = "Debes aceptar los términos y condiciones para registrarte.";
    }


    $telefono = isset($_POST['telefono']) ? sanear_y_validar($_POST['telefono']) : 'N/A';
    $fecha_evento = isset($_POST['fecha_evento']) ? sanear_y_validar($_POST['fecha_evento']) : 'N/A';
    $username = isset($_POST['username']) ? sanear_y_validar($_POST['username']) : 'N/A';
    $comentarios = isset($_POST['comentarios']) ? sanear_y_validar($_POST['comentarios']) : 'Sin comentarios';
    

    $preferencias_comida_array = isset($_POST['preferencias_comida']) && is_array($_POST['preferencias_comida']) ? $_POST['preferencias_comida'] : [];
    

    $preferencias_comida_str = '';

    foreach ($preferencias_comida_array as $pref) {
        $preferencias_comida_str .= sanear_y_validar($pref) . ', ';
    }

    $preferencias_comida_str = rtrim($preferencias_comida_str, ', ');
    if (empty($preferencias_comida_str)) {
        $preferencias_comida_str = 'Ninguna seleccionada';
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: #e0f7fa;
            padding-top: 50px;
        }
        .recibo-card {
            max-width: 800px;
            margin: 0 auto;
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }
        .recibo-header {
            background-color: #3d7f88ff;
            color: white;
            padding: 20px;
            border-radius: 1.5rem 1.5rem 0 0;
            text-align: center;
        }
        .data-label {
            font-weight: 600;
            color: #555;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card recibo-card">
        <div class="recibo-header">
            <?php echo "<h2>¡Registro completado!</h2>"; ?>
            <?php echo "<p>Confirmación de Datos Enviados</p>"; ?>
        </div>

        <div class="card-body p-4">
            
            <?php 

            if (!empty($errores)) { 
                echo '<div class="alert alert-danger" role="alert">';
                echo '<strong>¡ATENCIÓN! Se detectaron los siguientes errores en el servidor:</strong>';
                echo '<ul>';
                foreach ($errores as $error) {
                    echo "<li>" . $error . "</li>";
                }
                echo '</ul>';
                echo '</div>';
            } else {
                echo '<div class="alert alert-success" role="alert">Validación del Servidor: Datos recibidos y verificados correctamente.</div>';
            }

            echo "<h5>Información Personal</h5>";
            echo '<dl class="row">';
            echo '<dt class="col-sm-4 data-label">Nombre:</dt><dd class="col-sm-8">' . $nombre_completo . '</dd>';
            echo '<dt class="col-sm-4 data-label">Email:</dt><dd class="col-sm-8">' . $email . '</dd>';
            echo '</dl>';

            echo "<h5>Detalles del Evento</h5>";
            echo '<dl class="row">';
            echo '<dt class="col-sm-4 data-label">Fecha del Evento:</dt><dd class="col-sm-8">' . $fecha_evento . '</dd>';
            echo '<dt class="col-sm-4 data-label">Preferencias de Comida:</dt><dd class="col-sm-8">' . $preferencias_comida_str . '</dd>';
            echo '</dl>';

            echo "<h5>Comentarios Adicionales</h5>";
            echo '<p class="alert alert-light border">' . $comentarios . '</p>';

            if (isset($_FILES['archivo_adjunto']) && $_FILES['archivo_adjunto']['error'] == UPLOAD_ERR_OK) {
                echo '<div class="mt-3"><dt class="col-sm-4 data-label">Archivo Adjunto:</dt><dd class="col-sm-8">Archivo ' . htmlspecialchars($_FILES['archivo_adjunto']['name']) . ' recibido correctamente.</dd></div>';
            }

            ?>
        </div>
        
        <div class="card-footer text-center text-muted">
            <p class="mb-0">Gracias por registrarte. Tu información ha sido procesada.</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php 

} else {
    echo '<h1>Error de Acceso</h1>';
    echo '<p>Acceso denegado. Este archivo solo debe ser llamado mediante el envío de un formulario POST.</p>';
}

?>