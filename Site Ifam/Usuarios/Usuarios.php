<?php
session_start();
if (!(isset($_SESSION['permissao']))) {
	header('location: login.php');
} else {
	if ($_SESSION['permissao'] != 3)
		header('location: login.php');
}
if (isset($_POST['sair'])) {
	unset(
		$_SESSION['usuario'],
		$_SESSION['permissao']
	);
	header('location: login.php');
}
$usuario = filter_input(INPUT_GET, 'usuario', FILTER_SANITIZE_NUMBER_INT);
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

	<link rel="stylesheet" type="text/css" href="Sitelabs.css">

	<style type="text/css">
		/*************************************************** RELATORIO ***********************************************************/
		.relatorio {
			background-color: rgba(220, 220, 220, 0.4);
			color: black;
			border: none;
			border-radius: 5px;
			width: 100%;
			height: 450px;
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
			width: 80%;
			margin-bottom: 0.1%;
		}

		.salarelatorio {
			width: 90%;
			height: 25px;
			margin-left: 5%;
			border: solid 1px;
			border-radius: 5px;
		}

		.btn-grouprel {
			width: 90%;
			height: 25px;
			margin-left: 5%;
			border: solid 1px;
			border-radius: 5px;
			height: 30px;
			background-color: white;
			color: black;
		}

		.btnrelatorio {
			width: 90%;
			height: 25px;
			margin-left: 5%;
			border: solid 1px;
			border-radius: 5px;
			height: 30px;
			background-color: white;
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
			margin-left: 22%;
			margin-right: 12px;
			margin-top: 60px;
			background-color: #ffffff;
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
			background-color: white;
			border-radius: 8px;
			border: solid 1px;
		}

		.botaocad {
			font-size: 13px;
			padding: 5px;
			border: solid 1px;
			border-radius: 5px;
			background-color: #e6e4e4;
			color: black;
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
	<script>
		//Controle do numero de registros apresentados

		$(document).ready(function() {
			var mostra = 1;
			var dados = new FormData();
			var qregistro = document.getElementById("qregistro").value;
			inicio = 0;
			$("#mostrado").text($("#qregistro").val())

			dados.append('qregistro', qregistro);
			dados.append('inicio', inicio);
			// Gera tabela
			$.ajax({
				url: 'servidor/Usulogic.php',
				method: 'post',
				data: dados,
				processData: false,
				contentType: false,
				success: function(resposta) {
					document.getElementById("tabelarelatorio").innerHTML = resposta;
				}
			})

			var parametro = window.location.search;
			if (parametro !== "") {
				var usu = parametro.replace(/\?/g, "").replace(/%/g, "").replace(/20/g, " ");
				var usuD = new FormData();
				usuD.append('pesquisa', usu);
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("tabelarelatorio").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST", "servidor/Usulogic.php");
				xmlhttp.send(usuD);
			}
			// controla quantos registros aparecem
			$("#qregistro").change(function() {
				var dados = new FormData();
				var qregistro = document.getElementById("qregistro").value;
				mostra = 1;
				inicio = 0;
				document.getElementById('mostra').value = mostra;
				dados.append('inicio', inicio);
				dados.append('qregistro', qregistro);
				$.ajax({
					url: 'servidor/Usulogic.php',
					method: 'post',
					data: dados,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})

			//botão (primeiro)
			$("#primeiro").click(function() {
				var qregistro = document.getElementById("qregistro").value;
				var qregistro1 = parseInt(qregistro);
				mostra = 1;
				inicio = 0;

				document.getElementById('mostra').value = mostra;
				dados.append('qregistro', qregistro);
				dados.append('inicio', inicio);
				$.ajax({
					url: 'servidor/Usulogic.php',
					method: 'post',
					data: dados,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})

			//botão (anterior)
			$("#anterior").click(function() {
				var qregistro = document.getElementById("qregistro").value;
				var qregistro1 = parseInt(qregistro);

				if (inicio > 0) {
					inicio -= qregistro1;
					mostra -= 1;
					document.getElementById('mostra').value = mostra;

					dados.append('qregistro', qregistro);
					dados.append('inicio', inicio);
					$.ajax({
						url: 'servidor/Usulogic.php',
						method: 'post',
						data: dados,
						processData: false,
						contentType: false,
						success: function(resposta) {
							document.getElementById("tabelarelatorio").innerHTML = resposta;
						}
					})
				}
			})

			//botão (proximo)
			$("#proximo").click(function() {
				var qregistro = document.getElementById("qregistro").value;
				var qregistro1 = parseInt(qregistro);
				var Rtotal1 = document.getElementById("total").innerText;
				var Rtotal = parseInt(Rtotal1);
				if (inicio < Rtotal - qregistro1) {
					inicio += qregistro1;
					mostra += 1;
					document.getElementById('mostra').value = mostra;


					dados.append('qregistro', qregistro);
					dados.append('inicio', inicio);
					$.ajax({
						url: 'servidor/Usulogic.php',
						method: 'post',
						data: dados,
						processData: false,
						contentType: false,
						success: function(resposta) {
							document.getElementById("tabelarelatorio").innerHTML = resposta;
						}
					})
				}
			})

			//botão (ultimo)
			$("#ultimo").click(function() {
				var qregistro = document.getElementById("qregistro").value;
				var qregistro1 = parseInt(qregistro);
				var Rtotal1 = document.getElementById("total").innerText;
				var Rtotal = parseInt(Rtotal1);

				divide = Rtotal / qregistro1
				resto = Rtotal % qregistro1
				if (resto == 0) {
					inicio = Rtotal - qregistro1
					mostra = divide;
				} else {
					inicio = Rtotal - resto
					mostra = Math.ceil(divide);
				}

				document.getElementById('mostra').value = mostra;
				dados.append('qregistro', qregistro);
				dados.append('inicio', inicio);
				$.ajax({
					url: 'servidor/Usulogic.php',
					method: 'post',
					data: dados,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})
			//barra de pesquisa
			$(".pesquisa").click(function() {
				dadosp1 = new FormData();
				var enter = $("#txtBusca").val();
				dadosp1.append('pesquisa', enter);
				dadosp1.append('qregistro', 0);
				dadosp1.append('inicio', 0);

				$.ajax({
					url: 'servidor/Usulogic.php',
					method: 'post',
					data: dadosp1,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})
			$(".pesquisa1").click(function() {
				dadosp1 = new FormData();
				var enter = $("#txtBusca1").val();
				dadosp1.append('pesquisa', enter);
				dadosp1.append('qregistro', 0);
				dadosp1.append('inicio', 0);

				$.ajax({
					url: 'servidor/Usulogic.php',
					method: 'post',
					data: dadosp1,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})
		})

		function pesquisa(enter) {
			if (enter.length > 0) {
				document.onkeyup = function(e) {
					if (e.which == 13) {
						dadosp = new FormData();
						dadosp.append('pesquisa', enter);
						dadosp.append('qregistro', 0);
						dadosp.append('inicio', 0);

						$.ajax({
							url: 'servidor/Usulogic.php',
							method: 'post',
							data: dadosp,
							processData: false,
							contentType: false,
							success: function(resposta) {
								document.getElementById("tabelarelatorio").innerHTML = resposta;
							}
						})
						return false;
					} else {
						document.onkeyup = false;
					}
				}
			}
		}
	</script>
</head>

<body>
	<div class="container-fluid">
		<div class="fundo">

			<!-------------------------------------------------- CABEÇALHO DO SITE --------------------------------------------------->

			<div class="cabeçalho">
				<div class="row">
					<div class="col-2 col-lg-2 col-md-2 d-flex">
						<img class="d-none d-lg-block d-md-block  " src="imagens/logoifam.png" id="logo" />
					</div>
					<div class="col-12 col-lg-6 col-md-5 col-sm-12 text-center">
						<p class="tema">Reserva de Laboratórios</p>
						<p class="subtitulo d-block d-lg-block d-md-none">Campus Manaus Distrito Industrial</p>
					</div>
					<div class="col-3 col-lg-3 col-md-4 d-none d-lg-block d-md-block">
						<div id="divBusca">
							<input onkeydown="pesquisa(this.value)" id="txtBusca" type="text" class="txtBusca" />
							<img src="imagens/lupa.png" class="pesquisa" id="btnBusca" alt="Buscar" />
						</div>
					</div>
					<div class="col-1 col-md-1 d-none d-lg-block d-md-block">
						<div class="text-center usuario">
							<img src="imagens/login.png" id="login" />
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
					<div id="divBusca1">
						<input onkeydown="pesquisa(this.value)" id="txtBusca1" type="text" class="txtBusca" />
						<img src="imagens/lupa.png" class="pesquisa1" id="btnBusca" alt="Buscar" />
					</div>
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
							<a class="nav-link" href="Home.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Salas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link disabled" href="#">Ajuda</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="relatorio.php">Relatório</a>
						</li>
						<li class="nav-item active">
							<a class="nav-link" href="Usuarios.php">Usuários</a>
						</li>
					</ul>
				</div>
			</nav>

			<!----------------------------------------------------------RELATORIO---------------------------------------------------->
			<div class="row" style="padding: 10px;">
				<div class=" col-lg-12 col-md-12 col-sm-12">
					<a href="Cadastro.php" class="botaocad">Cadastrar novo usuario</a>
				</div>
			</div>
			<?php
			if (isset($_SESSION['msgsucess'])) {
				echo $_SESSION['msgsucess'];
				unset($_SESSION['msgsucess']);
			}

			if (isset($_SESSION['editamsg'])) {
				echo $_SESSION['editamsg'];
				unset($_SESSION['editamsg']);
			}
			// conexão
			$servername = 'localhost';
			$username = 'root';
			$password = '';
			$database = 'cordlab';
			$mysqli = new mysqli($servername, $username, $password, $database);
			// consulta pra verificação de quantidade de usuarios
			$consulta1 = $mysqli->query("SELECT * FROM usuarios");
			$Tregistros = $consulta1->num_rows;
			?>

			<div class="row" id="Lcomando">
				<hr>
				<div class="col-lg-2 col-md-2">
					<span id="total"><?php echo $Tregistros; ?></span> usuários cadastrados
				</div>
				<div style="margin-bottom: 10px;" class="col-lg-8 col-md-8">
					<button id="primeiro" class="botaotab">primeiro</button>
					<button id="anterior" class="botaotab">anterior</button>
					<input id="mostra" value="1" type="button" class="botaotab">
					<button id="proximo" class="botaotab">proximo</button>
					<button id="ultimo" class="botaotab">ultimo</button>
				</div>

				<div class="col-lg-2 col-md-2">mostrar
					<select name="qregistros" id="qregistro">
						<option value="25">25</option>
						<option value="50">50</option>
						<option value="75">75</option>
						<option value="100">100</option>
					</select>
					registros
				</div>


			</div>



			<div id="tabelarelatorio" class="table-responsive">


			</div>


		</div>

	</div>
	</div>

</body>

</html>