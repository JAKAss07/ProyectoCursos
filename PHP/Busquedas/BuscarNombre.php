<?php
include '../../Conexion/conexion.php';

if ($conn->connect_errno) {
    echo json_encode(["error" => "Error de conexión: " . $conn->connect_error]);
    exit;
}

$nombre = isset($_GET['nombre']) ? "%" . $conn->real_escape_string($_GET['nombre']) . "%" : null;
$categoria = isset($_GET['categoria']) ? $conn->real_escape_string($_GET['categoria']) : null;

// Construcción dinámica del SQL
$sql = "SELECT Curso.ID_Curso, Curso.Titulo, Curso.Precio, Usuario.Nombre_Usuario AS Autor
        FROM Curso
        INNER JOIN Usuario ON Curso.ID_Instructor = Usuario.ID
        WHERE 1=1";

$parametros = [];
$tipos = "";

// Filtro por nombre
if ($nombre !== null && $nombre !== "%%") {
    $sql .= " AND Curso.Titulo LIKE ?";
    $parametros[] = $nombre;
    $tipos .= "s";
}

// Filtro por categoría (excepto "all")
if ($categoria !== null && $categoria !== "all" && $categoria !== "") {
    $sql .= " AND Curso.Categoria = ?";
    $parametros[] = $categoria;
    $tipos .= "s";
}

$stmt = $conn->prepare($sql);

if (count($parametros) > 0) {
    $stmt->bind_param($tipos, ...$parametros);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<p>No se encontraron cursos con esos criterios.</p>";
} else {
    while ($row = $result->fetch_assoc()) {
        echo '
        <a href="PHP/CRUD_Curso/VerCursoU.php?id=' . $row["ID_Curso"] . '" id="linkCurso">
            <div id="curs">
                <div></div>
                <div id="descripcion_curso">
                    <p><strong>Nombre:</strong> ' . htmlspecialchars($row["Titulo"]) . '</p>
                    <p><strong>Autor:</strong> ' . htmlspecialchars($row["Autor"]) . '</p>
                    <p><strong>Precio:</strong> $' . htmlspecialchars($row["Precio"]).'</p>
                </div>
            </div>
        </a>';
    }
}

$stmt->close();
$conn->close();
