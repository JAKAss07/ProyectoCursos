<?php
session_start();
include '../../Conexion/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $sql = "SELECT ID, Nombre_Usuario, Contrasena, ID_Rol FROM Usuario WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($contrasena, $usuario["Contrasena"])) {
            $_SESSION["ID_Usuario"] = $usuario["ID"];
            $_SESSION["Nombre_Usuario"] = $usuario["Nombre_Usuario"];
            $_SESSION["Rol"] = $usuario["ID_Rol"];

            header("Location: ../../index.php");
            exit;
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Correo no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/Log.css">
</head>

<body>
    <div id="regresar">
        <a id="boton" href="../../Index.php">Regresar</a>
    </div>
    <div id="cont">
        <section id="iz">
            <img src="../../Img/Logo.png" alt="">
        </section>
        <section id="dr">
            <?php if ($mensaje): ?>
                <div id="mensajeS">
                    <p><?php echo htmlspecialchars($mensaje); ?></p>
                </div>
            <?php endif; ?>
            <form id="formulario" method="POST" action="">
                <h2>Iniciar sesión</h2>

                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}" title="Mínimo 8 caracteres, al menos una letra y un número" name="contrasena" required>


                <button id="bt_1" type="submit">Ingresar</button>
            </form>
            <div id="cont_bt">
                <button id="bt_2" onclick="window.location.href='../CRUD_User/CrearUser.php'">Crear Usuario</button>
                <!-- <button id="bt_2">Google</button> -->
            </div>
    </div>

    </section>
    </div>

</body>

</html>