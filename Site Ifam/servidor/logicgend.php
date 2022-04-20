<?php
session_start();
ini_set('display_errors', 0 );
error_reporting(0);

//criando conexão com o banco de dados
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);

// verificando os principais campos
if (!(isset($_POST['labs'], $_POST['tipo']))) {
  echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não foram preenchidos!</p>";
  
  exit();
} elseif ($_POST['começo'] == '' and $_POST["tipo"] !== "Manutenção") {
  echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não selecionados!</p>";
  exit();
} elseif ($_POST['termino'] == '' and $_POST["tipo"] !== "Manutenção") {
  echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não selecionados!</p>";
  exit();
}

//Tratando as informações recebidas

$especi = $_POST["item"];

$coments = $_POST["coments"];
$comeco = $_POST['começo'];
$termino = $_POST['termino'];
$permissao = $_SESSION['permissao'];
$dia = $_POST['dia'];
$labs = $_POST['labs'];
$area = $_POST['area'];
$hoje1 = date('Y-m-d');
$hoje = date('Y-m-d', strtotime('-1 days', strtotime($hoje1)));
$Usuario = $_SESSION['usuario'];
$Tipo = $_POST['tipo'];
$nomecompleto = $_SESSION["usuario"];
$permissao = $_SESSION["permissao"];
if (isset($_POST["permissao"])) {
  $permissao = $_POST["permissao"];
  $nomecompleto = $_POST["nome"];
}
$aex = $_POST["aex"];

// Agendamento em caso de manutenção
if($_POST["tipo"]=="Manutenção"){
  $inicioM = $_POST["inicioM"];
  $inicioM1 = $inicioM;
  $fimM = $_POST["fimM"];
  // verificando os campos de manutenção
  if (strtotime($inicioM) < strtotime($hoje)) {
    echo "<p style='color:red; margin-left: 3%;'>Dia de início invalido!</p>";
    exit();
  } elseif (strtotime($fimM) < strtotime($hoje)) {
   echo "<p style='color:red; margin-left: 3%;'>Dia do fim invalido!</p>";
    exit();
  }
    // verificando se existem agendamentos nesse periodo
    $consultaM = $mysqli->query("SELECT * FROM agendamentos
    WHERE Sala = '$labs' and  Dia >= '$inicioM' and Dia <= '$fimM'");
    //tratando os agendamentos obtidos, se obtidos
    if ($consultaM->num_rows != 0) {
     echo '<br><p style="color:red; margin-left: 3%;">Foram econtrados agendamentos neste periodo,
       <a href="Manutencao.php?inicio='.$inicioM.'&fim='.$fimM.'&sala='.$labs.'">clique aqui para ver</a>';
   } 
   //começando o agendamento
    while (strtotime($inicioM) <= strtotime($fimM)) {
        // iniciando conexão
        try {
          $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
          // configurando o PDO para tratamento de excessão
          $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          // incerção de dados
          $stmt = $conn->prepare("INSERT INTO agendamentos (nomecompleto, Area, Sala, Dia, Especificações, Coments, Comeco, Termino, InicioEx, FimEx, Usuario, Tipo, Permissão)
          VALUES ('Manutenção', '$area', '$labs', '$inicioM', '$especi', '$coments', '00:01', '23:59', '$inicioM1', '$fimM', '$Usuario', '$Tipo', '3')");
          $stmt->execute();
          echo "<p style='color:green; margin-left: 3%;'>Laboratório agendado para manutenção!</p>";
  
        } catch (PDOException $e) {
          echo "<p style='color:red; margin-left: 3%;'>Erro ao agendar laboratório para manutenção!</p>"; 
        }
        $conn = null;
      $inicioM = date('Y-m-d', strtotime('+1 days', strtotime($inicioM)));
    }
  exit();
}


//verificando se o horário é valido
if ($termino < $comeco) {
  echo "<p style='color:red; margin-left: 3%;'>Horario invalido!</p>";
  exit();
} elseif ($comeco < "07:00") {
  echo "<p style='color:red; margin-left: 3%;'>Horario fora do periodo de funcionamento!</p>";
  exit();
} elseif ($termino > "23:00") {
  echo "<p style='color:red; margin-left: 3%;'>Horario fora do periodo de funcionamento!</p>";
  exit();
}

// Verificando campos em caso de Administrador 
if ($_SESSION["permissao"] == 3) {
  if ($_POST["permissao"] == '') {
   echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não selecionados!</p>";
    exit();
  } elseif ($_POST['nome'] == '') {
    echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não selecionados!</p>";
    exit();
  }
}

// verificando tipo de agendamento
switch ($aex) {
  //agendamento normal
case "1":
  if (strtotime($dia) < strtotime($hoje)) {
   echo "<p style='color:red; margin-left: 3%;'>Dia invalido!</p>";
    exit();
  }
  //verificação de horario disponivel
  $consulta = $mysqli->query("SELECT id, Permissão, nomecompleto, Tipo FROM agendamentos
WHERE Sala = '$labs' and  Dia = '$dia' and Comeco < '$comeco' and Termino > '$comeco'
OR Sala = '$labs' and Dia = '$dia' and Comeco < '$termino' and Termino > '$termino'
OR Sala = '$labs' and Dia = '$dia' and Comeco >= '$comeco' and Termino <= '$termino'");

  if($consulta->num_rows != 0){
    $result = $consulta->fetch_array();
    $id = $$result["id"];
    if ($result["Permissão"] > 1) {
      if($result["Tipo"] == "Manutenção"){
        echo "<p style='color:red; margin-left: 3%;'>O laboratório escolhido está em manutenção durante período selecionado!</p>";
      }else{
        echo "<p style='color:red; margin-left: 3%;'>O horario escolhido ja está ocupado!</p>";
      }
      exit();
    }else{
      if ($permissao !=  1) {
        // apaga o agendamento sem prioridade obtido 
        $apaga = $mysqli->query("DELETE FROM agendamentos
        WHERE id = '$id'");
        echo "<p style='color:red; margin-left: 3%;'>Outro registro foi apagado por definições de prioridade!</p>";
      }else{
        echo "<p style='color:red; margin-left: 3%;'>O horario escolhido ja está ocupado!</p>";
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
    $stmt = $conn->prepare("INSERT INTO agendamentos (nomecompleto, Area, Sala, Dia, Especificações, Coments, Comeco, Termino, Usuario, Tipo, Permissão)
                             VALUES ('$nomecompleto', '$area', '$labs', '$dia', '$especi', '$coments', '$comeco', '$termino', '$Usuario', '$Tipo', '$permissao')");
    $stmt->execute();

    echo "<p style='color:green; margin-left: 3%;'>Agendado como sucesso!</p>";
  } catch (PDOException $e) {
    
   echo "<p style='color:red; margin-left: 3%;'>Erro ao agendar laboratório!</p>";
  }

  $conn = null;
  break;

//agendamento extendido
  case "2":
    // verificando campos
    $inicioex = $_POST["inicioex"];
    $inicioexDB = $inicioex;
    $fimex = $_POST["fimex"];
    $semanal = explode(",", $_POST["semanal"]);
    $semanalBD = $_POST["sema"];
    if (!(isset($semanal))) {
      echo "<p style='color:red; margin-left: 3%;'>Campos obrigatórios não foram preenchidos!</p>";
      exit();
    } elseif (strtotime($inicioex) < strtotime($hoje)) {
      echo "<p style='color:red; margin-left: 3%;'>Dia de início invalido!</p>";
      exit();
    } elseif (strtotime($fimex) < strtotime($hoje)) {
      echo "<p style='color:red; margin-left: 3%;'>Dia do fim invalido!</p>";
      exit();
    } elseif ($fimex < $inicioex) {
     echo "<p style='color:red; margin-left: 3%;'>Dia de início e fim invalido!</p>";
      exit();
    }

    $diasemana = date('w', strtotime($inicioex));
    // verificando dias a serem agendados
    while (strtotime($inicioex) <= strtotime($fimex)) {
      //verificando dias da semana
      if (in_array($diasemana, $semanal)) {
        // verificando horario ocupado
        //verificação de horario e data
        $consulta = $mysqli->query("SELECT id, Permissão, nomecompleto, Tipo FROM agendamentos
    WHERE Sala = '$labs' and  Dia = '$inicioex' and Comeco < '$comeco' and Termino > '$comeco'
    OR Sala = '$labs' and Dia = '$inicioex' and Comeco < '$termino' and Termino > '$termino'
    OR Sala = '$labs' and Dia = '$inicioex' and Comeco >= '$comeco' and Termino <= '$termino'");


if ($consulta->num_rows != 0) {
  $result = $consulta->fetch_array();
  $id = $result["id"];
  //verificando campos
  if ($result["Permissão"] > 1) {
    $pieces = explode("-", $inicioex);
    if($result["Tipo"] == "Manutenção"){
      echo "<p style='color:red; margin-left: 3%;'>Conflito com manutenção agendada para este laboratório, O agendamento ocorreu somente nos dias anteriores a " . $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0] . " </p>";
    }else{
      echo "<p style='color:red; margin-left: 3%;'>Conflito com horários já agendados, O agendamento ocorreu somente nos dias anteriores a " . $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0] . " </p>";
    }
    exit();
  } else {
    if ($permissao !=  1) {
      // apaga o agendamento sem prioridade obtido 
      $apaga = $mysqli->query("DELETE FROM agendamentos
      WHERE id = '$id'");
      echo "<p style='color:red; margin-left: 3%;'>Outro registro foi apagado por definições de prioridade!</p>";
    }else{
      echo "<p style='color:red; margin-left: 3%;'>Conflito com horários já agendados, O agendamento ocorreu somente nos dias anteriores a " . $pieces[2] . "/" . $pieces[1] . "/" . $pieces[0] . " </p>";
      exit();
    }
  }
}
// inserindo dados
try {
  $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  // configurando o PDO para tratamento de excessão
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // incerção de dados
  $stmt = $conn->prepare("INSERT INTO agendamentos (nomecompleto, Area, Sala, Dia, Especificações, Coments, Comeco, Termino, InicioEx, FimEx, Semanal, Usuario, Tipo, Permissão)
  VALUES ('$nomecompleto', '$area', '$labs', '$inicioex', '$especi', '$coments', '$comeco', '$termino', '$inicioexDB', '$fimex', '$semanalBD', '$Usuario', '$Tipo', '$permissao')");
$stmt->execute();

 
} catch (PDOException $e) {
  echo "<p style='color:red; margin-left: 3%;'>Erro ao agendar laboratório!</p>";
  exit();
}
$conn = null;

  }
  $inicioex = date('Y-m-d', strtotime('+1 days', strtotime($inicioex)));
  $diasemana = date('w', strtotime($inicioex));
}
echo "<p style='color:green; margin-left: 3%;'>Agendado com sucesso!</p>";
 break;
default:
echo "<p style='color:red; margin-left: 3%;'>Erro ao agendar laboratório!</p>";
}
