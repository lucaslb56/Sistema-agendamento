<?php
session_start();
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
$sala = "Comunicações";
if (isset($_POST["sala"])) {
    $sala = $_POST["sala"];
}
$query_events = "SELECT * FROM agendamentos WHERE Sala = '$sala'";
$resultado_events = $conn->prepare($query_events);
$resultado_events->execute();

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width" />
    <title>Cordenação de Laboratórios</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/Sitelabs.css">
    <link href='css/core/main.min.css' rel='stylesheet' />
    <link href='css/daygrid/main.min.css' rel='stylesheet' />
    <script src='js/core/main.min.js'></script>
    <script src='js/interaction/main.min.js'></script>
    <script src='js/daygrid/main.min.js'></script>
    <script src='js/core/locales/pt-br.js'></script>

    <script>
        function salas(A) {
            var mud = document.getElementById('salas' + A);

            switch (A) {
                case 1:
                    mud.style.display = 'block';
                    document.getElementById('salas2').style.display = 'none';
                    document.getElementById('salas3').style.display = 'none';
                    document.getElementById('salas4').style.display = 'none';
                    document.getElementById('salas5').style.display = 'none';
                    document.getElementById('legend').innerHTML = 'BLOCO B - 1º ANDAR';
                    break;
                case 2:
                    mud.style.display = 'block';
                    document.getElementById('salas1').style.display = 'none';
                    document.getElementById('salas3').style.display = 'none';
                    document.getElementById('salas4').style.display = 'none';
                    document.getElementById('salas5').style.display = 'none';
                    document.getElementById('legend').innerHTML = 'BLOCO B - TÉRREO';
                    break;
                case 3:
                    mud.style.display = 'block';
                    document.getElementById('salas1').style.display = 'none';
                    document.getElementById('salas2').style.display = 'none';
                    document.getElementById('salas4').style.display = 'none';
                    document.getElementById('salas5').style.display = 'none';
                    document.getElementById('legend').innerHTML = 'BLOCO C - 1º ANDAR';
                    break;
                case 4:
                    mud.style.display = 'block';
                    document.getElementById('salas1').style.display = 'none';
                    document.getElementById('salas2').style.display = 'none';
                    document.getElementById('salas3').style.display = 'none';
                    document.getElementById('salas5').style.display = 'none';
                    document.getElementById('legend').innerHTML = 'BLOCO C - EXTENÇÃO';
                    break;
                case 5:
                    mud.style.display = 'block';
                    document.getElementById('salas1').style.display = 'none';
                    document.getElementById('salas2').style.display = 'none';
                    document.getElementById('salas3').style.display = 'none';
                    document.getElementById('salas4').style.display = 'none';
                    document.getElementById('legend').innerHTML = 'BLOCO C - TÉRREO';
                    break;
                default:

            }
        }
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
                <?php

                if ($_SESSION['permissao'] == 3) {
                    echo "eventClick: function(info) {
                    info.jsEvent.preventDefault(); // don't let the browser navigate
                    window.location.href = 'Editar/Editaragend.php?id=' + info.event.id;
                },";
                }
                ?>
            });

            calendar.render();
        });

        $(document).ready(function() {
            $("label").click(function() {
                $("#sala").val($(this).text());
                document.getElementById("mudasala").submit();
            })

        })
    </script>
    <style>
        .agendamento {
            background-color: rgba(189, 185, 185, 0.2);
            padding: 5px;
            margin: 10px;
            border-radius: 5px;
        }

        #calendar {
            max-width: 950px;
            margin: 0 auto;
        }

        .btn-primary {
            background-color: #e0e0e0;
            color: black;
            border: solid 1px;
            border-radius: 5px;
            width: 140px;
            height: 35px;
            text-align: left;
            margin-right: 20px;
            margin-bottom: 10px;
        }

        .botao {
            background-color: #e0e0e0;
            color: black;
            border: solid 1px;
            border-radius: 5px;
            padding: 8px;
            text-align: left;
            margin-right: 20px;
            margin-bottom: 5px;
        }

        .botao:hover {
            color: black;
            text-decoration: none;
        }

        .btn-primary:hover {
            background-color: #e0e0e0;
            color: black;
            border: solid 1px;
        }

        .agendborda {
            border: 1px groove black;
            border-radius: 5px;
        }

        .agend1 {
            border-bottom: none;
            border-left: none;
            margin-top: 20px;
            margin-right: 10px;
            text-align: left;
        }

        .agendborda .legenda {
            height: 30px;
            font-size: 1.2em !important;
            text-align: left !important;
            width: auto;
            padding: 0 5px;
            border-bottom: none;
        }

        .calendario {
            width: 100%;
            border-radius: 5px;
            background-color: #ffffff;
            font-size: 12px;
        }


        #sair {
            background-color: #3db244;
            color: white;
            border: none;
            padding-right: 2px;

        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="fundo">
            <!-------------------------------------------------- CABEÇALHO DO SITE --------------------------------------------------->

            <div class="cabeçalho">
                <div class="row">
                    <div class="col-2 col-lg-2 col-md-2 d-flex">
                        <img class="d-none d-lg-block d-md-block  " src="../imagens/logoifam.png" id="logo" />
                    </div>
                    <div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
                        <p class="tema">Reserva de Laboratórios</p>
                        <p class="subtitulo">Campus Manaus Distrito Industrial</p>
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
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            ÁREAS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                        </button>
                        <div class="dropdown-menu">
                            <a onclick="salas(1)" class="dropdown-item" href="#">BLOCO B - 1º ANDAR</a>
                            <a onclick="salas(2)" class="dropdown-item" href="#">BLOCO B - TÉRREO</a>
                            <a onclick="salas(3)" class="dropdown-item" href="#">BLOCO C - 1º ANDAR</a>
                            <a onclick="salas(4)" class="dropdown-item" href="#">BLOCO C - EXTENÇÃO</a>
                            <a onclick="salas(5)" class="dropdown-item" href="#">BLOCO C - TÉRREO</a>
                        </div>
                    </div>
                    <a href="../Agendamento/Agendamento.php" class="botao">Agendar</a>
                    <fieldset class="agend1 agendborda">
                        <legend style="margin-bottom: 5px;" class="legenda">
                            <h4 id="legend">BLOCO B - 1º ANDAR</h4>
                        </legend><br>

                        <div id="salas1" action="">
                            <ul style="padding-left: 10px;">
                                <label class="labo" for="lab1">Comunicações</label> <br>
                                <label class="labo" for="lab2">Ópticas</label> <br>
                                <label class="labo" for="lab3">Lab. Programação I</label> <br>
                                <label class="labo" for="lab4">Lab. Programação IV</label> <br>
                                <label class="labo" for="lab5">MPCE</label> <br>
                                <label class="labo" for="lab6">Lab. Programação II</label> <br>
                                <label class="labo" for="lab7">Lab. Programação III</label> <br>
                                <label class="labo" for="lab8">Redes de Telecomunicações</label> <br>
                                <label class="labo" for="lab9">Sistemas de Telecom</label> <br>
                            </ul>
                        </div>
                        <div id="salas2" style="display: none;" action="">
                            <ul style="padding-left: 10px;">
                                <label class="labo" for="lab1">Indústria I</label> <br>
                                <label class="labo" for="lab2">Indústria II</label> <br>
                                <label class="labo" for="lab3">Indústria III</label> <br>
                                <label class="labo" for="lab4">Lab. FINEP</label> <br>
                            </ul>
                        </div>
                        <div id="salas3">

                        </div>
                        <div id="salas4" style="display: none;" action="">
                            <ul style="padding-left: 10px;">
                                <label class="labo" for="lab1">Lab. Robótica e Controle</label> <br>
                                <label class="labo" for="lab2">Lab. de Acionamentos/CLP</label> <br>
                                <label class="labo" for="lab3">Lab. de Ele. de potência</label> <br>
                                <label class="labo" for="lab4">Lab. Hidráulica/Pneumática</label> <br>
                            </ul>
                        </div>
                        <div id="salas5" style="display: none;" action="">
                            <ul style="padding-left: 10px;">
                                <label class="labo" for="lab1">Áudio e Vídeo</label> <br>
                                <label class="labo" for="lab2">Lab. de Automação</label> <br>
                                <label class="labo" for="lab3">CMDI MAKER</label> <br>
                                <label class="labo" for="lab4">Lab. de Física</label> <br>
                                <label class="labo" for="lab4">Quimica</label> <br>
                            </ul>
                        </div>
                        <form id="mudasala" method="POST" action="">
                            <input id="sala" style="display: none;" name="sala">
                        </form>
                    </fieldset>
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