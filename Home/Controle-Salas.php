
<?php
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);
$area = $_POST['area'];
$consulta = $mysqli->query("SELECT sala, id FROM salas WHERE area='$area'");

while ($salas = $consulta->fetch_array()) {
?>
    <label onclick="submit_sala(<?php echo $salas['id'];?>)" class="labo" id="<?php echo 'labs'.$salas["id"]; ?>"><?php echo $salas["sala"]; ?></label><br>
<?php } ?>

