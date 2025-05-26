<?php
include '../../Conexion/conexion.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    die("Solicitud inválida");
}

$idCurso = intval($_POST['id']);

$sql = "DELETE FROM Curso WHERE ID_Curso = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idCurso);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    // Redirigir a la página principal o lista de cursos
    header("Location: CursosCRUD.php");
    exit;
} else {
    echo "No se pudo borrar el curso o no existe.";
}

$stmt->close();
$conn->close();
