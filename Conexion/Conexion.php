<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cursos";
$port = "33065";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

header('Content-Type: application/json');

if ($conn->connect_errno) {
    $respuesta = array("mensaje" => $conn->connect_error);
    echo json_encode($respuesta);
    $conn->close();
    die();
} else {
    $respuesta = array("mensaje" => "Conexión correcta");
    echo json_encode($respuesta);
    $conn->close();
}
