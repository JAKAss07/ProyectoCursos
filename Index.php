<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Venta de Cursos</title>

    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/Estilos.css">

    <!-- JS-Búsqueda -->
    <script src="JS/BusquedasU.js"></script>

</head>

<body>
    <div id="cont">
        <section id="opciones">

            <div id="logo_i"><img src="Img/Logo.png" id="img_logo"></div>
            <div id="menuOp">
                <div>
                    <a href="" class="boton">
                        <h1>
                            <span>|</span>
                            Planes
                            <span>|</span>
                        </h1>
                    </a>
                </div>
                <?php if (isset($_SESSION["Rol"]) && $_SESSION["Rol"] == 2): ?>
                    <div>
                        <a href="PHP/CRUD_Curso/CursosCRUD.php" class="boton">
                            <h1>
                                <span>|</span>
                                Instructor
                                <span>|</span>
                            </h1>
                        </a>
                    </div>
                <?php endif; ?>

                <div id="con_botones_sesion">

                    <?php if (isset($_SESSION["ID_Usuario"])): ?>
                        <button id="bt_ini" onclick="window.location.href='PHP/CRUD_User/VerEditUser.php'">Perfil</button>
                        <button id="bt_ini" onclick="window.location.href='PHP/Login/logout.php'">Cerrar Sesión</button>
                    <?php else: ?>
                        <button id="bt_ini" onclick="window.location.href='PHP/Login/login.php'">Iniciar Sesión</button>
                    <?php endif; ?>



                </div>
            </div>

        </section>

        <section id="busqueda">
            <div>
                <h1>Buscar</h1>

                <input id="buscar" type="text" placeholder="Buscar cursos...">

            </div>
            <div>
                <h1>Categoría</h1>

                <select id="categoria">
                    <option value="all">Todas las Categorías</option>
                    <option value="Matemáticas">Matemáticas</option>
                    <option value="Manualidades">Manualidades</option>
                    <option value="Tecnología">Tecnología</option>
                    <option value="3D">3D</option>
                </select>

        </section>

        <section id="cursos" class="recientes">
            <div>
                <h1>Cursos</h1>
            </div>

            <div id="con_cursos">

            </div>
        </section>
    </div>
</body>

</html>