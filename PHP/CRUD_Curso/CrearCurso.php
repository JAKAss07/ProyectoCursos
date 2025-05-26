<?php
session_start();
require_once '../../Conexion/conexion.php';

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['ID_Usuario'])) {
        header("Location: ../Login/login.php");
        exit();
    }

    // DATOS DEL CURSO
    $idInstructor = $_SESSION['ID_Usuario'];
    $titulo = $_POST['NombreC'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $contenido = $_POST['quienCurso'] ?? '';
    $requisitos = $_POST['requisitoC'] ?? '';
    $precio = floatval($_POST['precioC'] ?? 0);
    $categoria = $_POST['categoria'] ?? '';
    $fecha = date('Y-m-d');
    $estado = "Pendiente";
    $modelo = 2; // ejemplo

    $linkIntroduccion = $_POST['linkIntro'] ?? '';  // NUEVO campo

    $titulosTemas = $_POST['tituloTema'] ?? [];
    $linksVideos = $_POST['linkVideo'] ?? [];

    if (count($titulosTemas) != count($linksVideos)) {
        $mensaje = "Error: Los temas no coinciden con los links.";
    } else {
        // INSERTAR CURSO (agregado campo Link_Introduccion)
        $sqlCurso = "INSERT INTO Curso (ID_Instructor, Titulo, Descripcion, ID_Modelo, Estado, Fecha_Creacion, Contenido, Precio, Categoria, Link_Introduccion)
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sqlCurso);
        $contenidoFinal = "¿Para quién?: " . $contenido . "\nRequisitos: " . $requisitos;
        $stmt->bind_param("issssssdss", $idInstructor, $titulo, $descripcion, $modelo, $estado, $fecha, $contenidoFinal, $precio, $categoria, $linkIntroduccion);

        if ($stmt->execute()) {
            $idCurso = $stmt->insert_id;

            $sqlTema = "INSERT INTO Temas (ID_Curso, Titulo_Tema, Link_Video) VALUES (?, ?, ?)";
            $stmtTema = $conn->prepare($sqlTema);

            for ($i = 0; $i < count($titulosTemas); $i++) {
                $tituloTema = $titulosTemas[$i];
                $linkVideo = $linksVideos[$i];
                $stmtTema->bind_param("iss", $idCurso, $tituloTema, $linkVideo);
                $stmtTema->execute();
            }

            $mensaje = "Curso y temas registrados correctamente.";

            header("refresh:2;url=../CRUD_Curso/CursosCRUD.php");
        } else {
            $mensaje = "Error al registrar el curso: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Crear Curso</title>
    <link rel="stylesheet" href="../../CSS/normalize.css" />
    <link rel="stylesheet" href="../../CSS/CrearCurso.css" />

    <script>
        function agregarTema() {
            const container = document.getElementById("temasContainer");
            const div = document.createElement("div");
            div.classList.add("tema-item");
            div.innerHTML = `
                <label>Título del tema:</label>
                <input type="text" name="tituloTema[]" required>
                <label>Link del video:</label>
                <input type="url" name="linkVideo[]" required>
                <button type="button" onclick="this.parentElement.remove()" id="boton_2">Eliminar</button>
                <hr>
            `;
            container.appendChild(div);
        }
    </script>
</head>

<body>
    <div id="cont_c">
        <section id="panelD">
            <div id="crearCurso">
                <form id="formulario" action="" method="POST">
                    <div id="conPaneles">
                        <div id="formIZ">
                            <h2>Crear Curso</h2>
                            <label for="nombreC">Nombre del curso:</label>
                            <input type="text" maxlength="70" id="nombreC" name="NombreC" required />

                            <label for="linkIntro">Link de Video de Introducción:</label> <!-- NUEVO campo -->
                            <input type="url" id="linkIntro" name="linkIntro" maxlength="300" />

                            <label for="categoria">Categoría:</label>
                            <select id="categoria" name="categoria" required>
                                <option value="">Selecciona</option>
                                <option value="Matematicas">Matemáticas</option>
                                <option value="Manualidades">Manualidades</option>
                                <option value="Tecnologia">Tecnología</option>
                                <option value="3D">3D</option>
                            </select>

                            <label for="precioC">Precio del Curso:</label>
                            <input type="number" min="0" max="1000000" id="precioC" name="precioC" required />

                            <label for="descripcion">Descripción:</label>
                            <input type="text" id="descripcion" maxlength="300" name="descripcion" required />

                            <label for="quienCurso">Para quien es el curso:</label>
                            <input type="text" id="quienCurso" maxlength="1500" name="quienCurso" required />

                            <label for="requisitoC">Requisitos para el curso:</label>
                            <input type="text" id="requisitoC" name="requisitoC" required />
                        </div>

                        <div id="formDR">
                            <h3>Temas del Curso</h3>
                            <div id="temasContainer">
                                <div class="tema-item">
                                    <label>Título del tema:</label>
                                    <input type="text" maxlength="70" name="tituloTema[]" required />
                                    <label>Link del video:</label>
                                    <input type="url" name="linkVideo[]" required />
                                    <button type="button" onclick="this.parentElement.remove()" id="boton_2">Eliminar</button>
                                    <hr />
                                </div>
                            </div>
                            <button type="button" onclick="agregarTema()" id="boton_1">Agregar Tema</button>
                        </div>
                    </div>

                    <button id="boton" type="submit">Crear Curso</button>
                </form>
            </div>
        </section>

        <section id="opciones_c">
            <div id="img_logo ">
                <div id="logo_i"><img src="../../Img/Logo.png" id="img_logo"></div>
            </div>
            <a id="boton" href="CursosCRUD.php">Regresar</a>

            <?php if ($mensaje): ?>
                <div id="mensajeS">
                    <p><?= htmlspecialchars($mensaje) ?></p>
                </div>
            <?php endif; ?>
        </section>
    </div>
</body>

</html>