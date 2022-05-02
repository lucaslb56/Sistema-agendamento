<?php
session_start();
ini_set('display_errors', 0);
error_reporting(0);
if (!(isset($_SESSION['permissao']))) {
    header('location: ../Login/login.php');
}
if (isset($_POST['sair'])) {
    unset(
        $_SESSION['usuario'],
        $_SESSION['permissao']
    );
    header('location: ../Login/login.php');
}

define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBNAME', 'cordlab');

$conn = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);
$sala = "";
if (isset($_POST["sala"])) {
    $sala = $_POST["sala"];
}
$query_events = "SELECT * FROM agendamentos WHERE Sala = '$sala'";
$resultado_events = $conn->prepare($query_events);
$resultado_events->execute();

$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'cordlab';
$mysqli = new mysqli($servername, $username, $password, $database);
$consulta1 = $mysqli->query("SELECT area FROM salas WHERE sala='$sala'");
$areaI = $consulta1->fetch_array();
$areaB = "SALAS";
if (isset($areaI["area"])) {
    $areaB = $areaI["area"];
}
$consulta2 = $mysqli->query("SELECT id, sala FROM salas WHERE area='$areaB'");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Coordenação de Laboratórios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/Sitelabs.css">
    <link rel="stylesheet" type="text/css" href="css/Home.css">
    <link href='css/core/main.min.css' rel='stylesheet' />
    <link href='css/daygrid/main.min.css' rel='stylesheet' />
    <script src='js/core/main.min.js'></script>
    <script src='js/interaction/main.min.js'></script>
    <script src='js/daygrid/main.min.js'></script>
    <script src='js/core/locales/pt-br.js'></script>
    <script src='js/Home.js'></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {

                locale: 'pt-br',
                plugins: ['dayGrid'],
                header: {
                    left: 'title',
                    right: 'prev,next'
                },
                footer: {
                    left: 'dayGridMonth,dayGridDay',
                    center: '',
                    right: 'prevYear,nextYear'
                },
                titleFormat: { // will produce something like "Tuesday, September 18, 2018"
                    month: 'numeric',
                    year: 'numeric',

                },
                //defaultDate: '2019-04-12',
                editable: true,
                eventLimit: false,
                events: [
                    <?php
                    while ($row_events = $resultado_events->fetch(PDO::FETCH_ASSOC)) {
                        $inicio = $row_events['Dia'] . " " . $row_events['Comeco'];
                        $fim = $row_events['Dia'] . " " . $row_events['Termino'];

                        if ($row_events['Tipo'] == "Manutenção") {
                            $cor = "#8B0000";
                            $inicio = $row_events['Dia'];
                        } elseif ($row_events['Permissão'] == 1) {
                            $cor = "#0071c5";
                        } else {
                            $cor = "#228B22";
                        }
                    ?> {
                            id: '<?php echo $row_events['id']; ?>',
                            title: '<?php echo $row_events['nomecompleto']; ?>',
                            color: '<?php echo $cor; ?>',
                            start: '<?php echo $inicio; ?>',
                            end: '<?php echo $fim; ?>'
                        },
                    <?php } ?>
                ],
                extraParams: function() {
                    return {
                        cachebuster: new Date().valueOf()
                    };
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                    window.location.href = 'Editar/Editaragend.php?id=' + info.event.id;
                },
            });

            calendar.render();
        });

        function submit_sala(id) {
            var sala = document.getElementById('labs' + id)
            document.getElementById("sala").value = sala.innerText
            document.getElementById("mudasala").submit()
        }
        $("label").click(function() {
            console.log("teste")
        })
        $(document).ready(function() {
            $(".salas-area").click(function() {
                var area = $(this).text();
                $("#legend").text($(this).text())
                var dados = new FormData();
                dados.append('area', area);
                $.ajax({
                    url: 'Controle-Salas.php',
                    method: 'post',
                    data: dados,
                    processData: false,
                    contentType: false,
                    success: function(resposta) {
                        document.getElementById('salas').innerHTML = resposta
                    }
                })

            })



            $("#input-mais").click(function() {
                $(".spinner-border").show();
                var salatxt = document.getElementById("nova-sala")
                var sala = salatxt.value
                var area = document.getElementById("nova-area").value;
                if (area == "") {
                    document.getElementById('resultado_sala').innerHTML = "<p style='color:red; margin-left: 3%;'>Campo obrigatório não preenchido</p>"
                    return
                }
                var dados = new FormData();
                dados.append('sala', sala);
                dados.append('area', area);
                $.ajax({
                    url: 'add-sala.php',
                    method: 'post',
                    data: dados,
                    processData: false,
                    contentType: false,
                    success: function(resposta) {
                        $(".spinner-border").hide();
                        document.getElementById('resultado_sala').innerHTML = resposta
                        salatxt.value = ""
                        salatxt.focus()
                    }
                })
            })
        })
    </script>
</head>

<body>

    <div class="container-fluid">
        <div class="fundo">
            <!-------------------------------------------------- CABEÇALHO DO SITE --------------------------------------------------->

            <div class="cabeçalho">
                <div class="row">
                    <div class="col-2 col-lg-2 col-md-2 d-flex">
                        <img class="d-none d-lg-block d-md-block  " src="../imagens/Logo.png" id="logo" />
                    </div>
                    <div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
                        <p class="tema">Coordenação de Laboratórios</p>
                        <p class="subtitulo">Sistema de administração de laboratórios</p>
                    </div>
                    <!-- (futura implementação, nesta tela, a barra de pesquisa deve levar a
                    wiki de laboratorios)
                    <div class="col-3 col-lg-3 col-md-4 d-none d-lg-block d-md-block">
                        <div id="divBusca">
                            <input type="search" class="txtBusca" />
                            <img src="imagens/lupa.png" id="btnBusca" alt="Buscar" />
                        </div>
                    </div>
                    -->
                    <div class="col-1 col-md-1 d-none d-lg-block d-md-block">
                        <div class="text-center usuario">
                            <img src="../imagens/login.png" id="login" />
                            <div id="nome">
                                <?php
                                $name = $_SESSION["usuario"];
                                function firstName($name)
                                {
                                    $array = explode(" ", $name);
                                    return $array[0];
                                }

                                echo firstName($name);
                                ?>
                            </div>
                        </div>
                        <form method="post">
                            <input type="submit" value="Sair" name="sair" id="botaologin" class="text-center">
                        </form>
                    </div>
                </div>
            </div>


            <!------------------------------------------------------BARRA DE PESQUISA--------------------------------------------------->

            <nav class="navbar navbar-expand-md navbar-light hidden-xs hidden-sm">

                <div class="d-block d-sm-block d-md-none">
                    <!-- (futura implementação, nesta tela, a barra de pesquisa deve levar a
                    de laboratorios)
                    <div id="divBusca1">
                        <input type="text" class="txtBusca" />
                        <img src="imagens/lupa.png" id="btnBusca" alt="Buscar" />
                    </div>
                    -->
                </div>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-sm-block d-md-none">
                            <a class="nav-link">
                                <form method="post">
                                    <input id="sair" type="submit" value="Sair" name="sair">
                                </form>
                            </a>
                        </li>
                        <li class="nav-item  active">
                            <a class="nav-link" href="Home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Salas</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#">Ajuda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../Relatorio/relatorio.php">Relatório</a>
                        </li>
                        <?php
                        if ($_SESSION['permissao'] == 3) {
                            echo '<li class="nav-item">
							<a class="nav-link" href="../Usuarios/Usuarios.php">Usuários</a>
						</li>';
                        }
                        ?>
                    </ul>
                </div>
            </nav>

            <!-------------------------------------Miolo do site--------------------------------------->

            <div class="agendamento row">
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <div class="btn-group area">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            ÁREAS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        </button>
                        <div class="dropdown-menu">
                            <?php
                            
                            $areas_repetidas = array();
                            $consulta = $mysqli->query("SELECT area FROM salas");

                            while ($areas = $consulta->fetch_array()) {
                                $area = $areas["area"];
                                if (!(in_array($area, $areas_repetidas))) {
                            ?>
                                    <a class="dropdown-item salas-area"><?php echo $area; ?></a>
                            <?php
                                    array_push($areas_repetidas, $area);
                                }
                            } ?>
                        </div>
                        <input style="display:none;" value="BLOCO B - 1º ANDAR" id="area" type="text">
                    </div>
                    <a href="../Agendamento/Agendamento.php" class="botao">Agendar</a>
                    <fieldset class="agend1 agendborda">
                        <legend style="margin-bottom: 20px;" class="legenda">
                            <h4 id="legend"><?php echo $areaB; ?></h4>
                        </legend>
                        <div id="salas">
                            <?php
                            while ($salas = $consulta2->fetch_array()) {
                            ?>
                                <label onclick="submit_sala(<?php echo $salas['id']; ?>)" class="labo" id="<?php echo 'labs' . $salas["id"]; ?>"><?php echo $salas["sala"]; ?></label><br>
                            <?php } ?>

                            <br><br><br><br><br><br><br><br><br><br><br>
                        </div>
                        <form id="mudasala" method="POST" action="">
                            <input id="sala" style="display: none;" name="sala">
                        </form>

                    </fieldset>
                    <button onclick="add_sala()" style="padding: 5px;" class="botao">Adicionar Sala</button>
                    <button style="padding: 5px;" class="botao">Remover Sala</button>
                    <div id="form-sala" style="display: none;">
                        <input placeholder="Sala" type="text" id="nova-sala" class="input-sala">
                        <input placeholder="Área" type="text" id="nova-area" class="input-sala">
                        <button id="input-mais">+</button>
                        <input onclick="remove_sala()" id="remove-form" type="button" value="x">
                    </div>
                    <div id="resultado_sala">
                        <div style="display:none; margin-left: 10px;" class="spinner-border"></div>
                    </div>
                </div>



                <div class="col-lg-9 col-md-8 col-sm-12 text-center">

                    <h3><?php echo $sala; ?></h3>
                    <div style="padding: 3px; border: solid #cccccc 1px; border-radius: 5px; margin-top: 10px;">
                        <div id='calendar'></div>
                    </div>
                </div>
            </div>
</body>

</html>