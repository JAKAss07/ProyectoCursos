<?php
include '../../Conexion/conexion.php';

if ($conn->connect_errno) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

if (isset($_GET['nombre'])) {
    $nombreCurso = "%" . $conn->real_escape_string($_GET['nombre']) . "%";

    $sql = "SELECT Curso.ID_Curso, Curso.Titulo, Usuario.ID AS Autor, '' AS Precio
            FROM Curso
            INNER JOIN Usuario ON Curso.ID_Instructor = Usuario.ID
            WHERE Curso.Titulo LIKE ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $nombreCurso);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<p>No se encontraron cursos con ese nombre.</p>";
    }

    while ($row = $result->fetch_assoc()) {
        echo '
        <a href="PHP/CRUD_Curso/VerCursoU.php?id=' . $row["ID_Curso"] . '" id="linkCurso">
            <div id="curs">
                <div></div>
                <div id="descripcion_curso">
                    <p><strong>Nombre:</strong> ' . htmlspecialchars($row["Titulo"]) . '</p>
                    <p><strong>Autor:</strong> ' . htmlspecialchars($row["Autor"]) . '</p>
                    <p><strong>Precio:</strong> ' . ($row["Precio"] === '' ? 'No disponible' : '$' . htmlspecialchars($row["Precio"])) . '</p>
                </div>
            </div>
        </a>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<p>Parámetro 'nombre' no proporcionado.</p>";
}
