<?php
session_start();
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // configurando o PDO para tratamento de excessão
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Preparando o comando sql e fixando os parâmetros
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = '$id'");

    $stmt->execute();

    $_SESSION['editamsg'] = "<p style='color:green; margin-top:10px;'>Usuário apagado com sucesso!</p>";
      header("Location: ../Usuarios.php");
  
  } catch(PDOException $e) {
    echo 'Erro' . '<br>' . $e->getMessage();
    $_SESSION['editamsg'] = "<p style='color:red;  margin-top:10px;'>Erro ao apagar usuário!</p>";
    header("Location: ../Usuarios.php");
  }

  $conn = null;


?>