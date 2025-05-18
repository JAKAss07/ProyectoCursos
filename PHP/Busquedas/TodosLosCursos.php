<?php
include '../../Conexion/conexion.php';

if ($conn->connect_errno) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

$sql = "SELECT Curso.ID_Curso, Curso.Titulo, Curso.Precio ,Usuario.ID AS Autor
        FROM Curso
        INNER JOIN Usuario ON Curso.ID_Instructor = Usuario.ID";

$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo "<p>No hay cursos registrados.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo '
        <a href="PHP/CRUD_Curso/VerCursoU.php?id=' . $row["ID_Curso"] . '" id="linkCurso">
            <div id="curs">
                <div><!-- htmlspecialchars($row["Titulo"])--></div>
                <div id="descripcion_curso">
                    <p><strong>Nombre:</strong> ' . htmlspecialchars($row["Titulo"]) . '</p>
                    <p><strong>Autor:</strong> ' . htmlspecialchars($row["Autor"]) . '</p>
                    <p><strong>Precio:</strong> $' . htmlspecialchars($row["Precio"]) . '</p>
                </div>
            </div>
        </a>';
    }
}

$conn->close();
