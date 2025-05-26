<?php
require_once '../../Conexion/conexion.php';

$mensaje = "";  // Mensaje a mostrar
$redireccionar = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $codigo = $_POST['codigo'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    $carrera = $_POST['carrera'];
    $contrasena = $_POST['contrasena'];

    $nombre_usuario = $nombre . ' ' . $apellidos;
    $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
    $id_rol = 2;

    // Validar si cédula o correo ya existen
    $checkSql = "SELECT ID FROM Usuario WHERE ID = ? OR Correo = ?";
    $stmtCheck = $conn->prepare($checkSql);
    $stmtCheck->bind_param("is", $codigo, $correo);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        $mensaje = "La cédula o el correo ya están registrados.";
    } else {
        $sql = "INSERT INTO Usuario (ID, Nombre_Usuario, Correo, Celular, Contrasena, Carrera, ID_Rol)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("isssssi", $codigo, $nombre_usuario, $correo, $celular, $contrasena_cifrada, $carrera, $id_rol);
            if ($stmt->execute()) {
                $mensaje = "Usuario creado exitosamente. Serás redirigido en 2 segundos...";
                $redireccionar = true;
            } else {
                $mensaje = "Error al crear el usuario: " . htmlspecialchars($stmt->error) . "</p>";
            }
            $stmt->close();
        } else {
            $mensaje = "Error al preparar la consulta: " . htmlspecialchars($conn->error) . "</p>";
        }
    }
    $stmtCheck->close();
    $conn->close();
}

// Redirección en PHP si fue exitoso
if ($redireccionar) {
    header("refresh:2;url=../Login/login.php");
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/CrearUser.css">
</head>

<body>

    <div id="regresar">
        <a id="boton" href="../Login/login.php">Regresar</a>
    </div>

    <div id="cont">


        <form id="formulario" method="POST" action="">
            <h2>Crear Usuario</h2>
            <div id="colum2">
                <div id="cam">
                    <label for="nombre">Nombres:</label>
                    <input type="text" pattern="[A-Za-z\s]+" maxlength="20" title="Solo Letras" id="nombre" name="nombre" required>
                </div>

                <div id="cam">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" pattern="[A-Za-z\s]+" maxlength="20" title="Solo Letras" id="apellidos" name="apellidos" required>
                </div>
            </div>

            <label for="codigo">Codigo/Cedula:</label>
            <input type="number" min="0000000000" max="9999999999" id="codigo" name="codigo" required>

            <label for="celular">Celular:</label>
            <input type="text" min="0000000000" max="9999999999" maxlength="10" id="celular" name="celular" required>

            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="">Selecciona</option>
                <option value="Ingeniería en Sistemas y Telecomunicaciones">Ingeniería en Sistemas y Telecomunicaciones</option>
                <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                <option value="Psicología">Psicología</option>
                <option value="Negocios Internacionales">Negocios Internacionales</option>
                <option value="Arquitectura">Arquitectura</option>
            </select>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}" title="Mínimo 8 caracteres, al menos una letra y un número" name="contrasena" required>

            <button id="bt_1" type="submit">Crear Usuario</button>

            <?php if ($mensaje): ?>
                <div id="mensajeS">
                    <p><?php echo htmlspecialchars($mensaje); ?></p>
                </div>
            <?php endif; ?>
        </form>

    </div>

</body>

</html>