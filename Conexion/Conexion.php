<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cursos";
$port = "33065";

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_errno) {
    // Aquí lanza error o detén el script, sin imprimir nada aún
    die(json_encode(array("error" => "Error de conexión: " . $conn->connect_error)));
}
