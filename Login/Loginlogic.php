<?php
    session_start();
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'cordlab';
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $mysqli = new mysqli($servername, $username, $password, $database);
    $consulta = $mysqli->query("SELECT senha, permissão, nomecompleto FROM usuarios WHERE email = '$email'");
    $result = $consulta->fetch_array();
    $senhadb = $result["senha"];
    $permissao = $result["permissão"];
    $nome = $result["nomecompleto"];
    echo $nome;
    $mysqli->close();

    if ($consulta->num_rows == 0) {
        $_SESSION['erroemail'] = "<p style='color:red; margin-left: 3%;'>Email não está cadastrado!</p>";
        header("Location: Login.php");
        }
        else {
            if ($senha == $senhadb) {
                $_SESSION["permissao"] = $permissao;
                $_SESSION["usuario"] = $nome;
                header("Location: ../Home/Home.php");
                }
                else { 
                    $_SESSION['errosenha'] = "<p style='color:red; margin-left: 3%;'>Email ou senha invalido!</p>";
                    header("Location: Login.php");
                           
        }
    }
