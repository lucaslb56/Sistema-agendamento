<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$mysqli = new mysqli($servername, $username, $password, $database);
// consulta pra verificação de quantidade de usuarios
$consulta1 = $mysqli->query("SELECT * FROM agendamentos WHERE id = '$id'");
$result1 = $consulta1->fetch_array();

$nome = $result1["nomecompleto"];
$area = $result1["Area"];
$sala = $result1["Sala"];
$comeco = $result1["Comeco"];
$termino = $result1["Termino"];
$inicioex = $result1["InicioEx"];
$fimex = $result1["FimEx"];
$semanal = $result1["Semanal"];
$usuario = $result1["Usuario"];
$tipo = $result1["Tipo"];
$permissao = $result1["Permissão"];
try {
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
      $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // configurando o PDO para tratamento de excessão
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Preparando o comando sql e fixando os parâmetros
					// conexão
          if($result1["Semanal"] != ""){
          $stmt = $conn->prepare("DELETE FROM agendamentos WHERE 
					nomecompleto = '$nome' and
					Area = '$area' and
					Sala = '$sala' and
					Comeco = '$comeco' and
					Termino = '$termino' and
					InicioEx = '$inicioex' and
					FimEx = '$fimex' and
					Semanal = '$semanal' and
					Usuario = '$usuario' and
					Tipo = '$tipo' and
					Permissão = '$permissao'");

          $stmt->execute();
          }elseif($result1["Tipo"] == "Manutenção"){
            $stmt2 = $conn->prepare("DELETE FROM agendamentos WHERE 
					nomecompleto = '$nome' and
					Area = '$area' and
					Sala = '$sala' and
					Comeco = '$comeco' and
					Termino = '$termino' and
					InicioEx = '$inicioex' and
					FimEx = '$fimex' and
					Usuario = '$usuario' and
					Tipo = '$tipo' and
					Permissão = '$permissao'");
          $stmt2->execute();
        }else{
          $stmt1 = $conn->prepare("DELETE FROM agendamentos WHERE id = '$id'");
          $stmt1->execute();
        }
    $_SESSION['editamsg'] = "<p style='color:green; margin-top:10px;'>Agendamento apagado com sucesso!</p>";
      header("Location: ../Home.php");
  
  } catch(PDOException $e) {
    echo 'Erro' . '<br>' . $e->getMessage();
    $_SESSION['editamsg'] = "<p style='color:red;  margin-top:10px;'>Erro ao apagar Agendamento!</p>";
    header("Location: ../Home.php");
  }

  $conn = null;
