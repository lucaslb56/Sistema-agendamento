<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$selecionados = $_POST['excluir'];
$id1 = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

foreach ($selecionados as $id) {
  $mysqli = new mysqli($servername, $username, $password, $database);
  $consulta = $mysqli->query("DELETE FROM agendamentos WHERE id = '$id'");
}

if ($mysqli->affected_rows) {
  $_SESSION['editamsg'] = "<p style='color:green; margin-top:10px;'>Agendamento(s) apagado com sucesso!</p>";
  header("Location: ../Exrelatorio.php?id=".$id1);
} else {
  $_SESSION['editamsg'] = "<p style='color:red;  margin-top:10px;'>Erro ao apagar Agendamento(s)!</p>";
  header("Location: ../Exrelatorio.php?id=".$id1);
}
