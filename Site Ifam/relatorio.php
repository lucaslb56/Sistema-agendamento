<?php
session_start();
if (!(isset($_SESSION['permissao']))) {
	header('location: login.php');
}
if (isset($_POST['sair'])) {
	unset(
		$_SESSION['usuario'],
		$_SESSION['permissao']
	);
	header('location: login.php');
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

	<link rel="stylesheet" type="text/css" href="Sitelabs.css">

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
			max-width: 438px;
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
		$(document).ready(function() {

			var mostra = 1;
			var dados = new FormData();
			var qregistro = document.getElementById("qregistro").value;
			var inicio = 0;
			$("#mostrado").text($("#qregistro").val())

			dados.append('qregistro', qregistro);
			dados.append('inicio', inicio);


			// gera tabela com filtros
			$("#gerarlatorio").click(function() {
				document.getElementById("mostracomando").style.display = "block";
				var qregistro = document.getElementById("qregistro").value;
				var nome = document.getElementById("aex3").value;
				var dia = document.getElementById("aex4").value;
				var area = document.getElementById("aex5").value;
				var sala = document.getElementById("aex6").value;
				var tipo = document.getElementById("aex7").value;
				dados.append('qregistro', qregistro);
				dados.append('nome', nome);
				dados.append('dia', dia);
				dados.append('area', area);
				dados.append('sala', sala);
				dados.append('tipo', tipo);

				$.ajax({
					url: 'servidor/relatoriologic.php',
					method: 'post',
					data: dados,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("tabelarelatorio").innerHTML = resposta;
					}
				})
			})

			// controla quantos registros aparecem
			$("#qregistro").change(function() {
				var dados = new FormData();
				var qregistro = document.getElementById("qregistro").value;
				mostra = 1;
				inicio = 0;
				var nome = document.getElementById("aex3").value;
				var dia = document.getElementById("aex4").value;
				var area = document.getElementById("aex5").value;
				var sala = document.getElementById("aex6").value;
				var tipo = document.getElementById("aex7").value;
				dados.append('qregistro', qregistro);
				dados.append('nome', nome);
				dados.append('dia', dia);
				dados.append('area', area);
				dados.append('sala', sala);
				dados.append('tipo', tipo);
				document.getElementById('mostra').value = mostra;
				dados.append('inicio', inicio);
				$.ajax({
					url: 'servidor/relatoriologic.php',
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
				var nome = document.getElementById("aex3").value;
				var dia = document.getElementById("aex4").value;
				var area = document.getElementById("aex5").value;
				var sala = document.getElementById("aex6").value;
				var tipo = document.getElementById("aex7").value;
				dados.append('qregistro', qregistro);
				dados.append('nome', nome);
				dados.append('dia', dia);
				dados.append('area', area);
				dados.append('sala', sala);
				dados.append('tipo', tipo);

				document.getElementById('mostra').value = mostra;
				dados.append('inicio', inicio);
				$.ajax({
					url: 'servidor/relatoriologic.php',
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
				var nome = document.getElementById("aex3").value;
				var dia = document.getElementById("aex4").value;
				var area = document.getElementById("aex5").value;
				var sala = document.getElementById("aex6").value;
				var tipo = document.getElementById("aex7").value;
				dados.append('qregistro', qregistro);
				dados.append('nome', nome);
				dados.append('dia', dia);
				dados.append('area', area);
				dados.append('sala', sala);
				dados.append('tipo', tipo);

				if (inicio > 0) {
					inicio -= qregistro1;
					mostra -= 1;
					document.getElementById('mostra').value = mostra;

					dados.append('inicio', inicio);
					$.ajax({
						url: 'servidor/relatoriologic.php',
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
					var nome = document.getElementById("aex3").value;
					var dia = document.getElementById("aex4").value;
					var area = document.getElementById("aex5").value;
					var sala = document.getElementById("aex6").value;
					var tipo = document.getElementById("aex7").value;
					dados.append('qregistro', qregistro);
					dados.append('nome', nome);
					dados.append('dia', dia);
					dados.append('area', area);
					dados.append('sala', sala);
					dados.append('tipo', tipo);
					dados.append('inicio', inicio);
					$.ajax({
						url: 'servidor/relatoriologic.php',
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
				var nome = document.getElementById("aex3").value;
				var dia = document.getElementById("aex4").value;
				var area = document.getElementById("aex5").value;
				var sala = document.getElementById("aex6").value;
				var tipo = document.getElementById("aex7").value;
				dados.append('qregistro', qregistro);
				dados.append('nome', nome);
				dados.append('dia', dia);
				dados.append('area', area);
				dados.append('sala', sala);
				dados.append('tipo', tipo);
				document.getElementById('mostra').value = mostra;
				dados.append('inicio', inicio);
				$.ajax({
					url: 'servidor/relatoriologic.php',
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
				document.getElementById("Lcomando").style.display = "none";
				dadosp1 = new FormData();
				var enter = $("#txtBusca").val();
				dadosp1.append('pesquisa', enter);
				dadosp1.append('qregistro', 0);
				dadosp1.append('inicio', 0);

				$.ajax({
					url: 'servidor/relatoriologic.php',
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
				document.getElementById("Lcomando").style.display = "none";
				dadosp1 = new FormData();
				var enter = $("#txtBusca1").val();
				dadosp1.append('pesquisa', enter);
				dadosp1.append('qregistro', 0);
				dadosp1.append('inicio', 0);

				$.ajax({
					url: 'servidor/relatoriologic.php',
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
			document.getElementById("Lcomando").style.display = "none";
			if (enter.length > 0) {
				document.onkeyup = function(e) {
					if (e.which == 13) {
						dadosp = new FormData();
						dadosp.append('pesquisa', enter);
						dadosp.append('qregistro', 0);
						dadosp.append('inicio', 0);

						$.ajax({
							url: 'servidor/relatoriologic.php',
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
						<li class="nav-item active">
							<a class="nav-link" href="relatorio.php">Relatório</a>
						</li>

						<?php
						if ($_SESSION['permissao'] == 3) {
							echo '<li class="nav-item">
							<a class="nav-link" href="Usuarios.php">Usuários</a>
						</li>';
						}
						?>
					</ul>
				</div>
			</nav>

			<!----------------------------------------------------------RELATORIO---------------------------------------------------->
			<div style="padding: 10px;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<div class="relatorio text-center">
							<?php
							if (isset($_SESSION['msgsucess'])) {
								echo $_SESSION['msgsucess'] . "<br>";
								unset($_SESSION['msgsucess']);
							}
							?>
							<fieldset class="agendarelatorio agendbordarelatorio">
								<legend class="legenda">
									<h4>FILTROS</h4>
								</legend>
								<label for="item1" class="filtrorelatorio">NOME</label><br>
								<input class="btnrelatorio" id="aex3" type="text"><br>

								<label for="item2" class="filtrorelatorio">DIA</label><br>
								<input class="btnrelatorio" class="data" id="aex4" type="date"><br>

								<label for="item3" class="filtrorelatorio">AREA</label><br>
								<select name="area" id="aex5" class="btnrelatorio">
									<option style="display: none;" value=""></option>
									<option value="BLOCO B - 1º ANDAR">BLOCO B - 1º ANDAR</option>
									<option value="BLOCO B - TÉRREO">BLOCO B - TÉRREO</option>
									<option value="BLOCO C - 1º ANDAR">BLOCO C - 1º ANDAR</option>
									<option value="BLOCO C - EXTENÇÃO">BLOCO C - EXTENÇÃO</option>
									<option value="BLOCO C - TÉRREO">BLOCO C - TÉRREO</option>
								</select><br>

								<label for="item4" class="filtrorelatorio">SALA</label><br>
								<input id="aex6" type="text" class="btnrelatorio"><br>

								<label for="item5" class="filtrorelatori">TIPO</label><br>
								<select id="aex7" class="btnrelatorio">
									<option style="display: none;" value=""></option>
									<option value="ENSINO">ENSINO</option>
									<option value="MANUTENÇÃO">MANUTENÇÃO</option>
									<option value="OUTROS">OUTROS</option>
								</select><br>



								<div style="padding: 10px;">
									<a href="#tabelarelatorio"><input id="gerarlatorio" type="submit" value="GERAR"></a>
								</div>
							</fieldset>
						</div>
					</div>
				</div>
				<?php

				// conexão
				$servername = 'localhost';
				$username = 'root';
				$password = '';
				$database = 'cordlab';
				$mysqli = new mysqli($servername, $username, $password, $database);
				// consulta pra verificação de quantidade de usuarios
				$consulta1 = $mysqli->query("SELECT * FROM agendamentos");
				$Tregistros = $consulta1->num_rows;
				if (isset($_SESSION['editamsg'])) {
					echo $_SESSION['editamsg'];
					unset($_SESSION['editamsg']);
				}
				?>
				<div style="display: none;" id="mostracomando">
					<div class="row" id="Lcomando">
						<hr>
						<div class="col-lg-2 col-md-2">
							<span id="total"><?php echo $Tregistros; ?></span> Agendamentos
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
				</div>
			</div>


			<div id="tabelarelatorio" class="table-responsive">

			</div>
		</div>
	</div>
	</div>

	</div>
	</div>

</body>

</html>