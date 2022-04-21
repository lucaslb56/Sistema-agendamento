<?php
session_start();
$id = $_POST["id"];
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);

$permissao = $_POST["permissão"];
$nome = $_POST["nome"];
$area = $_POST["area"];
$sala = $_POST["sala"];
$dia = $_POST["data"];
$comeco = $_POST["comeco"];
$termino = $_POST["termino"];
$tipo = $_POST["tipo"];
$espec = $_POST["espec"];
$coments = $_POST["coments"];
$usuario = $_POST["usuario"];


if ($termino < $comeco) {
    $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>Horario invalido!</p>";
    header("Location: ../Editaragend.php?id=".$id);
    exit();
  } elseif ($comeco < "07:00") {
    $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>Horario fora do periodo de funcionamento!</p>";
    header("Location: ../Editaragend.php?id=".$id);
    exit();
  } elseif ($termino > "23:00") {
    $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>Horario fora do periodo de funcionamento!</p>";
    header("Location: ../Editaragend.php?id=".$id);
    exit();
  }
  
  //verificação de horario disponivel
  $consulta = $mysqli->query("SELECT id, Permissão, nomecompleto, Tipo FROM agendamentos
WHERE Sala = '$sala' and  Dia = '$dia' and Comeco < '$comeco' and Termino > '$comeco'
OR Sala = '$sala' and Dia = '$dia' and Comeco < '$termino' and Termino > '$termino'
OR Sala = '$sala' and Dia = '$dia' and Comeco >= '$comeco' and Termino <= '$termino'");

  if($consulta->num_rows != 0){
    $result = $consulta->fetch_array();
    $id = $$result["id"];
    if ($result["Permissão"] > 1) {
      if($result["Tipo"] == "Manutenção"){
        $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>O laboratório escolhido está em manutenção durante período selecionado!</p>";
      }else{
        $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>O horario escolhido ja está ocupado!</p>";
      }
      header("Location: ../Editaragend.php?id=".$id);
      exit();
    }else{
      if ($permissao !=  1) {
        // apaga o agendamento sem prioridade obtido 
        $apaga = $mysqli->query("DELETE FROM agendamentos
        WHERE id = '$id'");
        $_SESSION['agenderro2'] = "<p style='color:red; margin-left: 3%;'>Outro registro foi apagado por definições de prioridade!</p>";
      }else{
        $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>O horario escolhido ja está ocupado!</p>";
        header("Location: ../Editaragend.php?id=".$id);
        exit();
      }
    }
  }

  // inserindo agendamento
  try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // configurando o PDO para tratamento de excessão
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // incerção de dados
    $stmt = $conn->prepare("INSERT INTO agendamentos (nomecompleto, Area, Sala, Dia, Especificações, Coments, Comeco, Termino, Tipo, usuario,  Permissão)
                             VALUES ('$nome', '$area', '$sala', '$dia', '$espec', '$coments', '$comeco', '$termino', '$Tipo', '$usuario', '$permissao')");
    $stmt->execute();

    $_SESSION['agendsucess'] = "<p style='color:green; margin-left: 3%;'>Alterado com sucesso!</p>";
    header("Location: ../Editaragend.php?id=".$id);
  } catch (PDOException $e) {
    echo 'Erro' . '<br>' . $e->getMessage();
    $_SESSION['agenderro1'] = "<p style='color:red; margin-left: 3%;'>Erro ao alterar agendamento!</p>";
    header("Location: ../Editaragend.php?id=".$id);
  }

  $conn = null;