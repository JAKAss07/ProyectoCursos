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

            <form id="formulario" action="ProcesarLogin.php" method="POST">
                <h2>Iniciar sesión</h2>

                <label for="correo">Correo electrónico:</label>
                <input type="email" id="correo" name="correo" required>

                <label for="contrasena">Contraseña:</label>
                <input type="password" id="contrasena" name="contrasena" required>


                <button id="bt_1" type="submit">Ingresar</button>
            </form>
            <div id="cont_bt">
                <button id="bt_2" onclick="window.location.href='../CRUD_User/CrearUser.php'">Crear Usuario</button>
                <button id="bt_2">Google</button>
            </div>
    </div>

    </section>
    </div>

</body>

</html>