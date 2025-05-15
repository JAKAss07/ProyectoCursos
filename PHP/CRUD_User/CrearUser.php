<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=}, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/CrearUser.css">
</head>

<body>
    <div id="regresar">
        <a id="boton" href="../Login/login.php">Regresar</a>
    </div>
    <div id="cont">
        <form id="formulario">
            <h2>Crear Usuario</h2>

            <div id="colum2">
                <div id="cam">
                    <label for="nombre">Nombres:</label>
                    <input type="text" id="nombre" name="nombre" required>
                </div>

                <div id="cam">
                    <label for="Apellidos">Apellidos:</label>
                    <input type="text" id="apellidos" name="apellidos" required>
                </div>

            </div>

            <label for="codigo">Codigo/Cedula:</label>
            <input type="number" id="codigo" name="codigo" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" id="correo" name="correo" required>

            <label for="carrera">Carrera:</label>
            <select id="carrera" name="carrera" required>
                <option value="">Selecciona</option>
                <option value="ing_industrial">Ingeniería en Sistemas y Telecomunicaciones</option>
                <option value="ing_industrial">Ingeniería Industrial</option>
                <option value="psicologia">Psicología</option>
                <option value="neg_internacionales">Negocios Internacionales</option>
                <option value="arquitectura">Arquitectura</option>
            </select>

            <label for="contrasena">Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button id="bt_1" type="submit">Crear Usuario</button>
        </form>
    </div>

</body>

</html>