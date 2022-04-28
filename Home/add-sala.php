<?php
$sala = $_POST["sala"];
$area = $_POST["area"];

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'cordlab');
try {
    $conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);

    $query_events = "INSERT INTO salas (sala, Area) VALUES ('$sala', '$area')";
    $resultado_events = $conn->prepare($query_events);
    $resultado_events->execute();
    echo "<p style='color:green; margin-left: 3%;'>Sala adicionada!</p>"; 
} catch (PDOException $e) {
    echo "<p style='color:red; margin-left: 3%;'>Erro ao adicionar sala!</p>"; 
  }