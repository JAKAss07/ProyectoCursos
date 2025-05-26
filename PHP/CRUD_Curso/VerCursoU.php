<?php
require_once '../../Conexion/conexion.php';

$idCurso = $_GET['id'] ?? null;

if (!$idCurso) {
    echo "Curso no especificado.";
    exit;
}

// Función para convertir link normal de YouTube a link embed
function getYouTubeEmbedUrl($url)
{
    // Ejemplo de URLs posibles:
    // https://www.youtube.com/watch?v=VIDEO_ID
    // https://youtu.be/VIDEO_ID
    // https://www.youtube.com/embed/VIDEO_ID

    if (strpos($url, 'youtube.com/embed/') !== false) {
        // Ya es link embed
        return $url;
    }

    if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Si no es un link YouTube válido, devolver vacío
    return '';
}

// Consulta de curso e instructor, incluyendo el link de introducción
$sql = "SELECT c.Titulo, c.Descripcion, c.Contenido, c.Precio, c.Categoria, c.Link_Introduccion, u.Nombre_Usuario, u.Carrera 
        FROM Curso c
        JOIN Usuario u ON c.ID_Instructor = u.ID
        WHERE c.ID_Curso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCurso);
$stmt->execute();
$result = $stmt->get_result();
$curso = $result->fetch_assoc();

if (!$curso) {
    echo "Curso no encontrado.";
    exit;
}

// Temas y subtemas
$sqlTemas = "SELECT Titulo_Tema, Link_Video FROM Temas WHERE ID_Curso = ?";
$stmtTemas = $conn->prepare($sqlTemas);
$stmtTemas->bind_param("i", $idCurso);
$stmtTemas->execute();
$temas = $stmtTemas->get_result()->fetch_all(MYSQLI_ASSOC);

// Obtener link embed para video de introducción
$linkIntroduccionEmbed = getYouTubeEmbedUrl($curso['Link_Introduccion']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curso</title>
    <link rel="stylesheet" href="../../CSS/normalize.css">
    <link rel="stylesheet" href="../../CSS/Curso.css">
</head>

<body>

    <div id="regresar">
        <a id="boton" href="../../Index.php">Regresar</a>
    </div>

    <div id="contGeneralCurso">
        <section id="sec1">
            <div id="cont_general">
                <h2><?= htmlspecialchars($curso['Titulo']); ?></h2>

                <?php if (!empty($linkIntroduccionEmbed)): ?>
                    <div class="video-container">
                        <iframe width="560" height="315" src="<?= htmlspecialchars($linkIntroduccionEmbed) ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                <?php else: ?>
                    <p>No hay video de introducción disponible.</p>
                <?php endif; ?>

                <h3>Instructor: <?= htmlspecialchars($curso['Nombre_Usuario']); ?> — Categoría: <?= htmlspecialchars($curso['Categoria']); ?></h3>
            </div>

            <div id="requisitos">
                <h2>Requisitos del curso</h2>
                <p><?= nl2br(htmlspecialchars($curso['Contenido'])); ?></p>
            </div>

            <div id="descripción">
                <h2>Descripción del curso</h2>
                <p><?= nl2br(htmlspecialchars($curso['Descripcion'])); ?></p>
            </div>

            <div id="temas">
                <h2>Temas del Curso</h2>
                <div id="cont_subTemas">
                    <?php foreach ($temas as $index => $tema): ?>
                        <h3>Tema <?= $index + 1; ?>: <?= htmlspecialchars($tema['Titulo_Tema']); ?></h3>
                        <div id="subTema">
                            <a href="<?= htmlspecialchars($tema['Link_Video']); ?>" target="_blank">Ver Video</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section id="preciosCurso">
            <div>
                <h2>Precio: $<?= number_format($curso['Precio'], 2); ?></h2>
            </div>
        </section>
    </div>

    <div id="infoInstructor">
        <p id="titInfroIns">Información del Instructor</p>
        <p id="texNormal">Nombre: <?= htmlspecialchars($curso['Nombre_Usuario']); ?></p>
        <p id="texNormal">Carrera: <?= htmlspecialchars($curso['Carrera']); ?></p>
    </div>

</body>

</html>