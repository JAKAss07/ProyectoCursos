<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto Venta de Cursos</title>

    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/Estilos.css">


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

                <div>
                    <a href="PHP/CursosCRUD.php" class="boton">
                        <h1>
                            <span>|</span>
                            Instructor
                            <span>|</span>
                        </h1>
                    </a>
                </div>
                <div>
                    <button id="bt_ini" onclick="window.location.href='PHP/Login/login.php'">Iniciar Sesión</button>
                    <button id="bt_ini" onclick="window.location.href='PHP/CRUD_User/VerEditUser.php'">Perfil</button>
                </div>
            </div>

        </section>

        <section id="busqueda">
            <div>
                <h1>Buscar</h1>

                <input type="text">

            </div>
            <div>
                <h1>Categoría</h1>

                <select id="category">
                    <option value="all">Todas las Categorías</option>
                    <option value="1">Matemáticas</option>
                    <option value="2">Manualidades</option>
                    <option value="3">Tecnología</option>
                    <option value="4">3D</option>
                </select>

        </section>

        <section id="cursos" class="recientes">
            <div>
                <h1>Cursos Recientes</h1>
            </div>

            <div id="con_cursos">
                <a href="PHP/CRUD_Curso/VerCurso.php" id="linkCurso">
                    <div id="curs">
                        <div><img src="Img/Logo.png" alt=""></div>
                        <spam>Nombre Curso</spam>
                        <spam>Autor</spam>
                        <spam>Precio</spam>

                    </div>
                </a>
            </div>
        </section>

        <section id="cursos" class="populares">
            <div>
                <h1>Cursos Populares</h1>
            </div>
            <div id="con_cursos">

            </div>

        </section>

    </div>
</body>

</html>