<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$selecionados = $_POST['excluir'];
$inicio = filter_input(INPUT_GET, 'inicio', FILTER_SANITIZE_NUMBER_INT);
$fim = filter_input(INPUT_GET, 'fim', FILTER_SANITIZE_NUMBER_INT);
$sala = filter_input(INPUT_GET, 'sala');
foreach ($selecionados as $id) {
  $mysqli = new mysqli($servername, $username, $password, $database);
  $consulta = $mysqli->query("DELETE FROM agendamentos WHERE id = '$id'");
}

if ($mysqli->affected_rows) {
  $_SESSION['editamsg'] = "<p style='color:green; margin-top:10px;'>Agendamento(s) apagado com sucesso!</p>";
  header("Location: ../Manutencao.php?inicio=".$inicio."&fim=".$fim."&sala=".$sala);
} else {
  $_SESSION['editamsg'] = "<p style='color:red;  margin-top:10px;'>Erro ao apagar Agendamento(s)!</p>";
  header("Location: ../Manutencao.php?inicio=".$inicio."&fim=".$fim."&sala=".$sala);
}
