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

$nome = "%".trim($_POST["nome"])."%";
$data = "%".trim($_POST["dia"])."%";
$area = "%".trim($_POST["area"])."%";
$sala = "%".trim($_POST["sala"])."%";
$tipo = "%".trim($_POST["tipo"])."%";


// consulta para gerar tabela
$consulta = $mysqli->query("SELECT * FROM agendamentos  
WHERE nomecompleto LIKE '$nome'
and Dia LIKE '$data' 
and Area LIKE '$area' 
and Sala LIKE '$sala' 
and Tipo LIKE '$tipo' 
ORDER BY id DESC 
LIMIT $incio, $qregistro");
// consulta para informar quantidade recebida
$consultaI = $mysqli->query("SELECT * FROM agendamentos 
WHERE nomecompleto LIKE '$nome'
and Dia LIKE '$data' 
and Area LIKE '$area' 
and Sala LIKE '$sala' 
and Tipo LIKE '$tipo' 
");
$resultado = $consulta;
$tmostrado = $consultaI->num_rows;
}
if (isset($_POST["pesquisa"])) {
    $pesquisa = "%" . trim($_POST["pesquisa"]) . "%";
    if ($pesquisa == "%aluno%") {
        $pesquisa = 1;
    } elseif ($pesquisa == "%professor%") {
        $pesquisa = 2;
    } elseif ($pesquisa == "%administrador%") {
        $pesquisa = 3;
    }
    $consultaP = $mysqli->query("SELECT * FROM agendamentos WHERE  
     nomecompleto LIKE '$pesquisa' OR
     Area LIKE '$pesquisa' OR
     Sala LIKE '$pesquisa' OR
     Tipo LIKE '$pesquisa' OR
     Comeco LIKE '$pesquisa' OR
     Termino LIKE '$pesquisa'
     ORDER BY id DESC");
    $resultado = $consultaP;
    $tmostrado = $consultaP->num_rows;
}
echo $tmostrado . " agendamento(s) obtido(s)";
?>

<table class="table table-striped">
    <thead>
        <tr id="primeira">
            <th scope="col">Agendado para:</th>
            <th scope="col">Area</th>
            <th scope="col">Sala</th>
            <th scope="col">Data</th>
            <th scope="col">Começo</th>
            <th scope="col">Termino</th>
            <th scope="col">Tipo</th>
            <th scope="col">Reservado por:</th>
            <th scope="col">Última atualização</th>
        </tr>
    </thead>
    <tbody>
        <div id="tabelaresult">
            <?php while ($result = $resultado->fetch_array()) {
                $pieces = explode("-", $result["Dia"]);
                $pieces1 = explode("-", $result["reg_date"]);
                $dia1 = explode(" ", $pieces1[2]);
                $pieces2 = explode(":", $result["Comeco"]);
                $pieces3 = explode(":", $result["Termino"]);

                switch ($result["Permissão"]) {
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
                    <td><?php
                    if ($_SESSION["permissao"] == 3) {
                        echo '<a style="color:black; font-size:17px; font-weight: 500;" href="../Home/Editar/Editaragend.php?id='.$result["id"].'">'.$result["nomecompleto"].'</a>';
                    }else{
                        echo $result["nomecompleto"];
                    } 
                    ?></td>
                    <td><?php echo $result["Area"]; ?></td>
                    <td><?php echo $result["Sala"]; ?></td>
                    <td><?php echo $pieces[2]."/".$pieces[1]."/".$pieces[0];  ?></td>
                    <td><?php echo $pieces2[0].":".$pieces2[1]; ?></td>
                    <td><?php echo $pieces3[0].":".$pieces3[1]; ?></td>
                    <td><?php echo $result["Tipo"]; ?></td>
                    <td>
                    <?php 
                    if ($_SESSION["permissao"] == 3) {
                        echo '<a style="color:black; font-size:17px; font-weight: 500;" href="../Usuarios/Usuarios.php?'.$result["Usuario"].'">'.$result["Usuario"].'</a>';
                    }else{
                        echo $result["Usuario"];
                    }
                     ?>
                </td>
                    <td><?php echo $dia1[0]."/".$pieces1[1]."/".$pieces1[0]." ".$dia1[1]; ?></td>
                </tr>
            <?php
            }   ?>
        </div>

        </tr>
    </tbody>
</table>