
<?php
    session_start();
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cordlab';
    $permissão = $_POST['permissão'];
    $email = $_POST['email'];
    $mysqli = new mysqli($servername, $username, $password, $database);
    $result = $mysqli->query("SELECT id FROM usuarios WHERE email = '$email'");
  
    $mysqli->close();
      
      if($permissão=='0'){
        $_SESSION['msg'] = "<p style='color:red; margin-left: 3%;'>Selecione a permissão!</p>";
        header("Location: ../cadastro.php");
      }else{
        if($result->num_rows > 0){
          $_SESSION['msgemail'] = "<p style='color:red; margin-left: 3%;'>Email ja esta cadastrado!</p>";
          header("Location: ../cadastro.php");
        }else{
      try {
        $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
        // configurando o PDO para tratamento de excessão
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        
      
        // Preparando o comando sql e fixando os parâmetros
        $stmt = $conn->prepare("INSERT INTO usuarios (nomecompleto, email, telefone, senha, permissão, turma)
                                VALUES (:nomecompleto, :email, :telefone, :senha, $permissão, :turma)");
        $stmt->bindParam(':nomecompleto', $nomecompleto);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':turma', $turma);

        // Alterando os valores dos parâmetros para insersão dos dados
        $nomecompleto = $_POST['nome'];
        $email = $_POST['email'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        $turma = $_POST['turma'];
        $stmt->execute();

        $_SESSION['msgsucess'] = "<p style='color:green; margin-top:10px;'>Cadastro feito com sucesso!</p>";
          header("Location: ../Usuarios.php");
      
      } catch(PDOException $e) {
        echo 'Erro' . '<br>' . $e->getMessage();
        $_SESSION['msg'] = "<p style='color:red; margin-top:10px;'>Erro ao cadastrar usuario!</p>";
	      header("Location: ../Usuarios.php");
      }

      $conn = null;
    }
  }
    
?>