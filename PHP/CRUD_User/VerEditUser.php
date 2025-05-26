<?php
session_start();
require_once '../../Conexion/conexion.php';

if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: ../Login/login.php");
    exit();
}

$mensaje = "";
$tipo_mensaje = "";
$id_usuario = $_SESSION['ID_Usuario'];

// Procesar formulario (editar o borrar)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['editar'])) {
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $celular = $_POST['celular'];
        $carrera = $_POST['carrera'];
        $correo = $_POST['correo'];
        $contrasena = $_POST['contrasena'];

        $nombre_usuario = $nombre . ' ' . $apellidos;

        // Verificar si se ingresó una nueva contraseña
        if (!empty($contrasena)) {
            $contrasena_cifrada = password_hash($contrasena, PASSWORD_DEFAULT);
            $sql = "UPDATE Usuario SET Nombre_Usuario=?, Celular=?, Carrera=?, Correo=?, Contrasena=? WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nombre_usuario, $celular, $carrera, $correo, $contrasena_cifrada, $id_usuario);
        } else {
            $sql = "UPDATE Usuario SET Nombre_Usuario=?, Celular=?, Carrera=?, Correo=? WHERE ID=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $nombre_usuario, $celular, $carrera, $correo, $id_usuario);
        }

        if ($stmt->execute()) {
            $mensaje = "Datos actualizados correctamente.";
        } else {
            $mensaje = "Error al actualizar: " . $stmt->error;
        }
        $stmt->close();
    }

    if (isset($_POST['borrar'])) {
        $stmt = $conn->prepare("DELETE FROM Usuario WHERE ID = ?");
        $stmt->bind_param("i", $id_usuario);
        if ($stmt->execute()) {
            session_destroy();
            header("Location: ../../Index.php");
            exit();
        } else {
            $mensaje = "Error al eliminar perfil.";
        }
    }
}

// Obtener datos actualizados
$sql = "SELECT * FROM Usuario WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();
$stmt->close();
$conn->close();


$partes_nombre = explode(' ', $usuario['Nombre_Usuario'], 2);
$nombre = $partes_nombre[0];
$apellidos = $partes_nombre[1] ?? '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Datos Usuario</title>
    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/CrearUser.css">
</head>

<body>
    <div id="regresar">
        <a id="boton" href="../../Index.php">Regresar</a>
    </div>
    <div id="cont">
        <form id="formulario" method="POST">
            <h2>Datos Usuario</h2>

            <?php if ($mensaje): ?>
                <div id="mensajeS">
                    <p><?php echo htmlspecialchars($mensaje); ?></p>
                </div>
            <?php endif; ?>

            <div id="colum2">
                <div id="cam">
                    <label for="nombre">Nombres:</label>
                    <input type="text" pattern="[A-Za-z\s]+" maxlength="20" title="Solo Letras" id="nombre" name="nombre" required value="<?= htmlspecialchars($nombre) ?>">
                </div>

                <div id="cam">
                    <label for="apellidos">Apellidos:</label>
                    <input type="text" pattern="[A-Za-z\s]+" maxlength="20" title="Solo Letras" id="apellidos" name="apellidos" required value="<?= htmlspecialchars($apellidos) ?>">
                </div>
            </div>

            <label for="codigo">Código/Cédula:</label>
            <input type="number" min="0000000000" max="9999999999" id="codigo" name="codigo" readonly value="<?= $usuario['ID'] ?>">

            <label for="celular">Celular:</label>
            <input type="text" min="0000000000" max="9999999999" id="celular" name="celular" required value="<?= htmlspecialchars($usuario['Celular']) ?>">

            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="">Selecciona</option>
                <option value="Ingeniería en Sistemas y Telecomunicaciones" <?= ($usuario['Carrera'] == 'Ingeniería en Sistemas y Telecomunicaciones') ? 'selected' : '' ?>>Ingeniería en Sistemas y Telecomunicaciones</option>
                <option value="Ingeniería Industrial" <?= ($usuario['Carrera'] == 'Ingeniería Industrial') ? 'selected' : '' ?>>Ingeniería Industrial</option>
                <option value="Psicología" <?= ($usuario['Carrera'] == 'Psicología') ? 'selected' : '' ?>>Psicología</option>
                <option value="Negocios Internacionales" <?= ($usuario['Carrera'] == 'neg_internacionales') ? 'selected' : '' ?>>Negocios Internacionales</option>
                <option value="Arquitectura" <?= ($usuario['Carrera'] == 'Arquitectura') ? 'selected' : '' ?>>Arquitectura</option>
            </select>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required value="<?= htmlspecialchars($usuario['Correo']) ?>">

            <label for="contrasena">Contraseña (dejar vacía si no deseas cambiarla):</label>
            <input type="password" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}" title="Mínimo 8 caracteres, al menos una letra y un número" id="contrasena" name="contrasena">

            <div id="colum2" class="bb">
                <button id="bt_1" type="submit" name="editar">Editar Datos</button>
                <button id="bt_1" type="submit" name="borrar" onclick="return confirm('¿Estás seguro de eliminar tu perfil?')">Borrar Perfil</button>
            </div>
        </form>
    </div>
</body>

</html>