<?php
session_start();
$id = $_POST["id"];
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';


$nome = $_POST["nome"];
$email = $_POST["email"];
$senha = $_POST["senha"];
$permissão = $_POST["permissão"];
$telefone = "";
$turma = "";

if ($_POST["Nsenha"] != "") {
    $senha = $_POST["Nsenha"];
}
if ($_POST["telefone"] != "") {
    $telefone = $_POST["telefone"];
}
if ($_POST["turma"] != "") {
    $turma = $_POST["turma"];
}

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // configurando o PDO para tratamento de excessão
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Preparando o comando sql e fixando os parâmetros
    $stmt = $conn->prepare("UPDATE usuarios
    SET nomecompleto = '$nome', telefone = '$telefone', email = '$email', senha = '$senha', permissão = '$permissão', turma = '$turma' 
   WHERE id = '$id'");

    $stmt->execute();

    $_SESSION['editamsg'] = "<p style='color:green; margin-top:10px;'>Alteração feita com sucesso!</p>";
      header("Location: ../Usuarios.php");
  
  } catch(PDOException $e) {
    echo 'Erro' . '<br>' . $e->getMessage();
    $_SESSION['editamsg'] = "<p style='color:red;  margin-top:10px;'>Erro ao fazer alteração!</p>";
      header("Location: ../Usuarios.php");
  }

  $conn = null;

