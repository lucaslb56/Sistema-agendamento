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
    <input type="radio" id="<?php echo 'labs'.$salas["id"]; ?>" name="labs" value="<?php echo $salas["sala"]; ?>"> 
    <label class="labo" for="<?php echo 'labs'.$salas["id"]; ?>"><?php echo $salas["sala"]; ?></label><br>
<?php } ?>