<?php
$lab = filter_input(INPUT_GET, 'lab');
$inicioM = filter_input(INPUT_GET, 'inicioM', FILTER_SANITIZE_NUMBER_INT);
$fimM = filter_input(INPUT_GET, 'fimM', FILTER_SANITIZE_NUMBER_INT);
echo $lab."<br>";
echo $inicioM."<br>";
echo $fimM."<br>";
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);
$consultaM = $mysqli->query("SELECT * FROM agendamentos
    WHERE Sala = '$lab' and  Dia >= '$inicioM' and Dia <= '$fimM'");

while ($result = $consultaM->fetch_array()) {
    if($result['Tipo']!='Manutenção'){
        echo $result['id']."<br>";
    }
    
}