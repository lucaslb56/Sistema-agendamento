<?php
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'cordlab');

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);
$salaCalendario = "Comunicações";
if (isset($_POST["salaCalendario"])) {
    $salaCalendario = $_POST["salaCalendario"];
}

$query_events = "SELECT * FROM agendamentos WHERE Sala = '$salaCalendario'";
$resultado_eventos = $conn->prepare($query_events);
$resultado_eventos->execute();


while ($row_eventos = $resultado_eventos->fetch(PDO::FETCH_ASSOC)) {
    $inicio = $row_eventos['Dia'] . " " . $row_eventos['Comeco'];
    $fim = $row_eventos['Dia'] . " " . $row_eventos['Termino'];

    if ($row_eventos['Tipo'] == "Manutenção") {
        $cor = "#8B0000";
        $inicio = $row_eventos['Dia'];
    } elseif ($row_eventos['Permissão'] == 1) {
        $cor = "#0071c5";
    } else {
        $cor = "#228B22";
    }

    $id = $row_eventos['id'];
    $title = $row_eventos['nomecompleto'];
    $color = $cor;
    $start = $inicio;
    $end = $fim;
    
    $evento[] = [
        'id' => $id, 
        'title' => $title, 
        'color' => $color, 
        'start' => $start, 
        'end' => $end, 
        ];
}
if(empty($evento)){
    $evento = 0;
}
echo json_encode($evento);