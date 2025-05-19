<?php
session_start();
include '../../Conexion/conexion.php';  // tu archivo de conexión

// Verifica si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    // Prepara y ejecuta la consulta
    $sql = "SELECT ID, Nombre_Usuario, Contrasena, ID_Rol FROM Usuario WHERE Correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Verifica contraseña (asumiendo que está hasheada)
        if (password_verify($contrasena, $usuario["Contrasena"])) {
            // Inicia sesión
            $_SESSION["usuario_id"] = $usuario["ID"];
            $_SESSION["nombre_usuario"] = $usuario["Nombre_Usuario"];
            $_SESSION["rol"] = $usuario["ID_Rol"]; // puedes usar JOIN para traer el nombre del rol

            // Redirige al panel principal o a donde necesites
            header("Location: ../../index.php");
            exit;
        } else {
            echo "<p>Contraseña incorrecta. </p>";
        }
    } else {
        echo "Correo no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
