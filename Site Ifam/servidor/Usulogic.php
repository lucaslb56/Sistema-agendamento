<?php
session_start();
// conexão
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);
// controles de exibição de dados
if (!(isset($_POST["pesquisa"]))) {
$incio = $_POST["inicio"];
$qregistro = $_POST["qregistro"];
$consulta = $mysqli->query("SELECT * FROM usuarios ORDER BY reg_date DESC LIMIT $incio, $qregistro");
$resultado = $consulta;
}
if (isset($_POST["pesquisa"])) {
    $pesquisa ="%". trim($_POST["pesquisa"])."%";
    if($pesquisa == "%aluno%"){
        $pesquisa = 1;
    }elseif ($pesquisa == "%professor%") {
        $pesquisa = 2;
    }elseif ($pesquisa == "%administrador%") {
        $pesquisa = 3;
    }
    $consultaP = $mysqli->query("SELECT * FROM usuarios WHERE
     nomecompleto LIKE '$pesquisa' OR
     email LIKE '$pesquisa' OR
     permissão LIKE '$pesquisa' OR
     turma LIKE '$pesquisa' OR
     telefone LIKE '$pesquisa' 
     ORDER BY id DESC ");
    $resultado = $consultaP;
    $tmostrado = $consultaP->num_rows;
    echo $tmostrado." resultado(s) obtido(s)";
}
?>

<table class="table table-striped">
    <thead>
        <tr id="primeira">
            <th scope="col">Usuário</th>
            <th scope="col">Permissão</th>
            <th scope="col">Email</th>
            <th scope="col">Telefone</th>
            <th scope="col">Turma</th>
            <th scope="col">Alterar</th>
        </tr>
    </thead>
    <tbody>
        <div id="tabelaresult">
            <?php  while ($result = $resultado->fetch_array()) {
                switch ($result["permissão"]) {
                    case 1:
                        $permissão = "Aluno";
                        break;
                    case 2:
                        $permissão = "Professor";
                        break;
                    case 3:
                        $permissão = "Administrador";
                        break;
                    default:
                }
            ?>
                <tr>
                    <td><?php echo $result["nomecompleto"]; ?></td>
                    <td><?php echo $permissão; ?></td>
                    <td><?php echo $result["email"]; ?></td>
                    <td><?php echo $result["telefone"]; ?></td>
                    <td><?php echo $result["turma"]; ?></td>
                    <td>
                        <?php echo '<a href="Editar.php?id=' . $result["id"] . '" class="botaoalte">Editar</a>' ?>
                    </td>
                </tr>
            <?php
              }   ?>
        </div>

        </tr>
    </tbody>
</table>
