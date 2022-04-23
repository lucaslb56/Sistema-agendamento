<?php
session_start();
if (!(isset($_SESSION['permissao']))) {
	header('location: ../../Login/login.php');
}
if (isset($_POST['sair'])) {
	unset(
		$_SESSION['usuario'],
		$_SESSION['permissao']
	);
	header('location: ../../Login/login.php');
}
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

	<link rel="stylesheet" type="text/css" href="../../css/Sitelabs.css">

	<style type="text/css">
		/*************************************************** RELATORIO ***********************************************************/
		.relatorio {
			background-color: rgba(220, 220, 220, 0.4);
			color: black;
			border: none;
			border-radius: 5px;
			width: 100%;
			text-align: left;
			padding: 10px;
			margin: 2px;
		}

		.agendbordarelatorio {
			border: 1px groove black;
			border-radius: 5px;
		}

		.agendbordarelatorio .legenda {
			height: 30px;
			font-size: 1.2em !important;
			text-align: left !important;
			width: auto;
			padding: 0 0 px;
			border-bottom: none;
			margin-left: 15%;
		}

		.agendarelatorio {
			background-color: white;
			width: 438px;
			height: 80%;
		}

		.comentariosrelatorio {
			width: 100%;
			height: 250px;
			box-shadow: 0 0 0 0;
			border: 0 none;
			outline: 0;
		}

		.filtrorelatorio {
			margin-bottom: 0.1%;
		}

		.salarelatorio {
			width: 90%;
			height: 25px;
			margin-left: 5%;
			border: solid 1px;
			border-radius: 5px;
		}

		.btnrelatorio {
			width: 90%;
			height: 25px;
			border: solid 1px;
			border-radius: 5px;
			height: 30px;
			background-color: #F0F8FF;
			color: black;
		}

		.btnrelatorio:hover {
			background-color: white;
			border-color: black;
			color: black;
		}

		#gerarlatorio {
			font-size: 1.2em !important;
			width: 60%;
			height: 13%;
			border: solid 1px;
			border-radius: 5px;
			padding-left: 0px;
			margin-top: 20px;
			background-color: #F0F8FF;
			color: black;
			text-align: center;
		}

		#gerarlatorio:active {
			transform: translateY(4px);
			box-shadow: 0 5px #666;
		}

		#tabelarelatorio {
			padding-top: 10px;
		}

		#primeira {
			background-color: #4ed656;
		}

		.botaotab {
			padding: 0px 7px;
			margin-right: 0%;
			margin-top: 2px;
			background-color: red;
			border-radius: 8px;
			border: solid 1px;
		}

		.botaocad {
			font-size: 13px;
			padding: 5px;
			border: solid 1px;
			border-radius: 5px;
			background-color: #B22222;
			color: black;
			cursor: pointer;
		}

		.botaoalte {
			font-size: 13px;
			padding: 5px;
			border: solid 1px;
			border-radius: 5px;
			background-color: #e6e4e4;
			color: black;
			margin: 0px;
		}

		.botaoalte:hover {
			color: black;
			text-decoration: none;
		}

		.botaocad:hover {
			text-decoration: none;
			color: black;
		}

		#Lcomando {
			width: 100%;
			margin-right: 5px;
			text-align: center;
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
						<img class="d-none d-lg-block d-md-block  " src="../../imagens/logoifam.png" id="logo" />
					</div>
					<div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
						<p class="tema">Reserva de Laboratórios</p>
						<p class="subtitulo d-block d-lg-block d-md-none">Campus Manaus Distrito Industrial</p>
					</div>
					<div class="col-1 col-md-1 d-none d-lg-block d-md-block">
						<div class="text-center usuario">
							<img src="../../imagens/login.png" id="login" />
							<div id="nome"><?php
											$name = $_SESSION["usuario"];
											function firstName($name)
											{
												$array = explode(" ", $name);
												return $array[0];
											}

											echo firstName($name);
											?></div>
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
						<li class="nav-item">
							<a class="nav-link" href="../Home.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Salas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Ajuda</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="../../Relatorio/relatorio.php">Relatório</a>
						</li>

						<?php
						if ($_SESSION['permissao'] == 3) {
							echo '<li class="nav-item">
							<a class="nav-link" href="../../Usuarios/Usuarios.php">Usuários</a>
						</li>';
						}
						?>
					</ul>
				</div>
			</nav>

			<!----------------------------------------------------------RELATORIO---------------------------------------------------->
			<div class="row" style="padding: 10px;">
				<div class="col-lg-12 col-md-12 col-sm-12">


					<?php
					$inicio = filter_input(INPUT_GET, 'inicio', FILTER_SANITIZE_NUMBER_INT);
					$fim = filter_input(INPUT_GET, 'fim', FILTER_SANITIZE_NUMBER_INT);
					$sala = filter_input(INPUT_GET, 'sala');
					$paran = "inicio=" . $inicio . "&fim=" . $fim . "&sala=" . $sala;
					// conexão
					$servername = 'localhost';
					$username = 'root';
					$password = '';
					$database = 'cordlab';
					$mysqli = new mysqli($servername, $username, $password, $database);
					// consulta pra verificação de quantidade de usuarios
					$consulta1 = $mysqli->query("SELECT * FROM agendamentos 
					 WHERE Sala = '$sala'
					 AND Dia >= '$inicio'
					 AND Dia <= '$fim'
					 ORDER BY Dia ASC 
					 ");

					if (isset($_SESSION['editamsg'])) {
						echo $_SESSION['editamsg'] . "<br>";
						unset($_SESSION['editamsg']);
					}
					?>


					<div id="tabelarelatorio" class="table-responsive">
						<form method="post" action="Excluir/Excluir2.php<?php echo "?inicio=" . $inicio . "&fim=" . $fim . "&sala=" . $sala; ?>">
							<div class="modal fade" id="modalExclui" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header bg-danger">
											<h5 class="modal-title" id="exampleModalLabel">Excluir</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Tem certeza que deseja excluir os agendamentos selecionados? </p>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
											<input type="submit" class="btn btn-danger" value="Excluir">
										</div>
									</div>
								</div>
							</div>
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
										<th scope="col"><input data-toggle="modal" data-target="#modalExclui" class="botaocad" value="Apagar" type="button"></th>
									</tr>
								</thead>
								<tbody>
									<div id="tabelaresult">
										<?php while ($result = $consulta1->fetch_array()) {
											if ($result["Tipo"] != "Manutenção") {
												$pieces = explode("-", $result["Dia"]);
												$dia = explode(" ", $pieces[2]);
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
															echo '<a style="color:black; font-size:17px; font-weight: 500;" href="Editaragend.php?id=' . $result["id"] . '">' . $result["nomecompleto"] . '</a>';
														} else {
															echo $result["nomecompleto"];
														}
														?></td>
													<td><?php echo $result["Area"]; ?></td>
													<td><?php echo $result["Sala"]; ?></td>
													<td><?php echo $dia[0] . "/" . $pieces[1] . "/" . $pieces[0];  ?></td>
													<td><?php echo $pieces2[0] . ":" . $pieces2[1]; ?></td>
													<td><?php echo $pieces3[0] . ":" . $pieces3[1]; ?></td>
													<td><?php echo $result["Tipo"]; ?></td>
													<td>
														<?php
														if ($_SESSION["permissao"] == 3) {
															echo '<a style="color:black; font-size:17px; font-weight: 500;" href="Usuarios.php?' . $result["Usuario"] . '">' . $result["Usuario"] . '</a>';
														} else {
															echo $result["Usuario"];
														}
														?>
													</td>
													<td><?php echo $dia1[0] . "/" . $pieces1[1] . "/" . $pieces1[0] . " " . $dia1[1]; ?></td>
													<?php echo '<td>
											<input style="width:20px; height:20px; margin-left:10px;" name="excluir[]" value="' . $result["id"] . '" type="checkbox">
											</td>' ?>
												</tr>
										<?php
											}
										} ?>
									</div>

									</tr>
								</tbody>
							</table>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>

</body>

</html>