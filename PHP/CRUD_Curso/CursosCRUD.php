<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>

    <link rel="stylesheet" href="../../CSS/Estilos.css">
    <link rel="stylesheet" href="../../CSS/CursoCRUD.css">
    <link rel="stylesheet" href="../../CSS/normalize.css">

</head>

<body>
    <div id="cont">
        <section id="opciones">
            <div id="logo_i"><img src="../../Img/Logo.png" id="img_logo"></div>
            <div id="menuOp1">
                <div>
                    <a href="../../index.php" class="boton">
                        <h1>
                            <span>|</span>
                            Estudiante
                            <span>|</span>
                        </h1>
                    </a>
                </div>
            </div>
        </section>

        <section id="busqueda">
            <div>
                <h1>Buscar</h1><input type="text">
            </div>
            <div>
                <h1>Categoría</h1>
                <select id="categoria">
                    <option value="all">Todas las Categorías</option>
                    <option value="1">Matemáticas</option>
                    <option value="2">Manualidades</option>
                    <option value="3">Tecnología</option>
                    <option value="4">3D</option>
                </select>
            </div>

            <div>
                <button id="bt_crc" onclick="window.location.href='CrearCurso.php'">Crear Curso</button>
            </div>
        </section>

        <section id="cursos">
            <div>
                <h1>Cursos Creados</h1>
            </div>
            <div id="con_cursos">
                <a href="VerCursoU.php" id="linkCurso">
                    <div id="curs">
                        <div><img src="../../Img/Logo.png" alt=""></div>
                        <div id="descripcion_curso">
                            <p>Nombre:</p>
                            <p>Autor:</p>
                            <p>Precio:</p>
                        </div>
                    </div>
                </a>
            </div>

        </section>
    </div>
</body>

</html>