<?php
session_start();
require_once '../../Conexion/conexion.php';

if (!isset($_SESSION['ID_Usuario'])) {
    header("Location: ../Login/login.php");
    exit();
}

if (!isset($_GET['id_curso'])) {
    echo "No se especificó el curso.";
    exit();
}

$idCurso = intval($_GET['id_curso']);
$idInstructor = $_SESSION['ID_Usuario'];
$mensaje = "";

// Obtener datos del curso para precargar el formulario
$sqlCurso = "SELECT * FROM Curso WHERE ID_Curso = ? AND ID_Instructor = ?";
$stmtCurso = $conn->prepare($sqlCurso);
$stmtCurso->bind_param("ii", $idCurso, $idInstructor);
$stmtCurso->execute();
$resultCurso = $stmtCurso->get_result();

if ($resultCurso->num_rows === 0) {
    echo "Curso no encontrado o no tienes permisos para editarlo.";
    exit();
}

$curso = $resultCurso->fetch_assoc();

// Obtener temas actuales
$sqlTemas = "SELECT * FROM Temas WHERE ID_Curso = ?";
$stmtTemas = $conn->prepare($sqlTemas);
$stmtTemas->bind_param("i", $idCurso);
$stmtTemas->execute();
$resultTemas = $stmtTemas->get_result();
$temas = [];
while ($row = $resultTemas->fetch_assoc()) {
    $temas[] = $row;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['NombreC'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $contenido = $_POST['quienCurso'] ?? '';
    $requisitos = $_POST['requisitoC'] ?? '';
    $precio = floatval($_POST['precioC'] ?? 0);
    $categoria = $_POST['categoria'] ?? '';
    $modelo = 2; // ejemplo fijo, o lo puedes traer del form
    $linkIntroduccion = $_POST['linkIntro'] ?? '';

    $titulosTemas = $_POST['tituloTema'] ?? [];
    $linksVideos = $_POST['linkVideo'] ?? [];

    if (count($titulosTemas) !== count($linksVideos)) {
        $mensaje = "Error: Los temas no coinciden con los links.";
    } else {
        $contenidoFinal = "¿Para quién?: " . $contenido . "\nRequisitos: " . $requisitos;

        $sqlUpdateCurso = "UPDATE Curso SET Titulo = ?, Descripcion = ?, ID_Modelo = ?, Contenido = ?, Precio = ?, Categoria = ?, Link_Introduccion = ? WHERE ID_Curso = ? AND ID_Instructor = ?";
        $stmtUpdateCurso = $conn->prepare($sqlUpdateCurso);

        $stmtUpdateCurso->bind_param("ssisdssii", $titulo, $descripcion, $modelo, $contenidoFinal, $precio, $categoria, $linkIntroduccion, $idCurso, $idInstructor);

       // echo "Link introducción recibido: " . htmlspecialchars($linkIntroduccion) . "<br>";

        if ($stmtUpdateCurso->execute()) {
            // Borra temas viejos
            $sqlDeleteTemas = "DELETE FROM Temas WHERE ID_Curso = ?";
            $stmtDelete = $conn->prepare($sqlDeleteTemas);
            $stmtDelete->bind_param("i", $idCurso);
            $stmtDelete->execute();

            // Inserta nuevos temas
            $sqlInsertTema = "INSERT INTO Temas (ID_Curso, Titulo_Tema, Link_Video) VALUES (?, ?, ?)";
            $stmtInsertTema = $conn->prepare($sqlInsertTema);

            for ($i = 0; $i < count($titulosTemas); $i++) {
                $tituloTema = $titulosTemas[$i];
                $linkVideo = $linksVideos[$i];
                $stmtInsertTema->bind_param("iss", $idCurso, $tituloTema, $linkVideo);
                $stmtInsertTema->execute();
            }

            $mensaje = "Curso modificado correctamente.";

            header("refresh:2;url=../CRUD_Curso/CursosCRUD.php");
        } else {
            $mensaje = "Error al modificar el curso: " . $stmtUpdateCurso->error;
        }
    }
}


// Descomponer contenido para rellenar campos
$contenidoSplit = explode("\nRequisitos: ", $curso['Contenido']);
$paraQuien = $contenidoSplit[0] ?? '';
$requisitos = $contenidoSplit[1] ?? '';
$paraQuien = str_replace("¿Para quién?: ", "", $paraQuien);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modificar Curso</title>
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
                            <h2>Modificar Curso</h2>

                            <label for="nombreC">Nombre del curso:</label>
                            <input type="text" maxlength="70" id="nombreC" name="NombreC" value="<?= htmlspecialchars($curso['Titulo']) ?>" required />

                            <label for="linkIntro">Link de Video de Introducción:</label>
                            <input type="url" id="linkIntro" name="linkIntro" maxlength="300" value="<?= htmlspecialchars($curso['Link_Introduccion'] ?? '') ?>" />

                            <label for="categoria">Categoría:</label>
                            <select id="categoria" name="categoria" required>
                                <option value="">Selecciona</option>
                                <option value="Matematicas" <?= $curso['Categoria'] === 'Matematicas' ? 'selected' : '' ?>>Matemáticas</option>
                                <option value="Manualidades" <?= $curso['Categoria'] === 'Manualidades' ? 'selected' : '' ?>>Manualidades</option>
                                <option value="Tecnologia" <?= $curso['Categoria'] === 'Tecnologia' ? 'selected' : '' ?>>Tecnología</option>
                                <option value="3D" <?= $curso['Categoria'] === '3D' ? 'selected' : '' ?>>3D</option>
                            </select>

                            <label for="precioC">Precio del Curso:</label>
                            <input type="number" min="0" max="1000000" id="precioC" name="precioC" value="<?= htmlspecialchars($curso['Precio']) ?>" required />

                            <label for="descripcion">Descripción:</label>
                            <input type="text" id="descripcion" maxlength="300" name="descripcion" value="<?= htmlspecialchars($curso['Descripcion']) ?>" required />

                            <label for="quienCurso">Para quien es el curso:</label>
                            <input type="text" id="quienCurso" maxlength="1500" name="quienCurso" value="<?= htmlspecialchars($paraQuien) ?>" required />

                            <label for="requisitoC">Requisitos para el curso:</label>
                            <input type="text" id="requisitoC" name="requisitoC" value="<?= htmlspecialchars($requisitos) ?>" required />
                        </div>

                        <div id="formDR">
                            <h3>Temas del Curso</h3>
                            <div id="temasContainer">
                                <?php foreach ($temas as $tema): ?>
                                    <div class="tema-item">
                                        <label>Título del tema:</label>
                                        <input type="text" maxlength="70" name="tituloTema[]" value="<?= htmlspecialchars($tema['Titulo_Tema']) ?>" required />
                                        <label>Link del video:</label>
                                        <input type="url" name="linkVideo[]" value="<?= htmlspecialchars($tema['Link_Video']) ?>" required />
                                        <button type="button" onclick="this.parentElement.remove()" id="boton_2">Eliminar</button>
                                        <hr />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" onclick="agregarTema()" id="boton_1">Agregar Tema</button>
                        </div>
                    </div>

                    <button id="boton" type="submit">Modificar Curso</button>
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