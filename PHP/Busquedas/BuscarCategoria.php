<?php
include '../conexion.php';
if (isset($_GET['tema'])) {
    $tema = "%" . $conn->real_escape_string($_GET['tema']) . "%";

    $sql = "SELECT Curso.ID_Curso, Curso.Titulo AS CursoTitulo, Temas.Titulo AS TemaTitulo
            FROM Curso
            INNER JOIN Temas ON Curso.ID_Curso = Temas.ID_Curso
            WHERE Temas.Titulo LIKE ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $tema);
    $stmt->execute();

    $result = $stmt->get_result();

    echo "<h2>Resultados por tema:</h2>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "Curso: " . $row["CursoTitulo"] . " | Tema: " . $row["TemaTitulo"] . "<br>";
        }
    } else {
        echo "No se encontraron cursos con ese tema.";
    }

    $stmt->close();
}

$conn->close();
