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
	<link href='css/core/main.min.css' rel='stylesheet' />
	<link href='css/daygrid/main.min.css' rel='stylesheet' />
	<script src='js/core/main.min.js'></script>
	<script src='js/interaction/main.min.js'></script>
	<script src='js/daygrid/main.min.js'></script>
	<script src='js/core/locales/pt-br.js'></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<title>Coordenação de Laboratórios</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/Sitelabs.css">
	<style>
		/*----------------------------------------Agendamento---------------------------------------*/
		.agendamento {
			background-color: rgba(189, 185, 185, 0.2);
			padding: 5px;
			margin: 10px;
			border-radius: 5px;
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
			margin-bottom: 5px;
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

		.agend2 {
			background-color: white;
			margin-top: 20px;
			padding: 10px;
		}

		.comentarios {
			width: 100%;
			height: 250px;
			box-shadow: 0 0 0 0;
			border: 0 none;
			outline: 0;
		}

		.carousel-indicators .bola {
			opacity: 100%;
			border: solid 1px;
			width: 20px;
			height: 20px;
			border-radius: 50%;
			margin-right: 20px;
		}

		.carousel-indicators .active {
			background-color: black;
		}

		.filtro {
			width: 120px;
			margin-bottom: 5%;
			margin-left: 5%;
		}

		.switch {
			position: relative;
			display: inline-block;
			width: 60px;
			height: 28px;
		}

		.switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}

		.slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: white;
			-webkit-transition: .4s;
			transition: .4s;
			border: solid 1px;
		}

		.slider:before {
			position: absolute;
			content: "";
			height: 24px;
			width: 24px;
			left: 2px;
			top: 1px;
			background-color: black;
			-webkit-transition: .4s;
			transition: .4s;
		}

		.switch input:checked+.slider {
			background-color: #3bff00;
		}

		.switch input:checked+.slider:before {
			-webkit-transform: translateX(30px);
			-ms-transform: translateX(30px);
			transform: translateX(30px);
		}

		/* Rounded sliders */
		.slider.round {
			border-radius: 34px;
		}

		.slider.round:before {
			border-radius: 50%;
		}

		.filtroN {
			width: 50px;
			border: solid 1px;
			opacity: 100%;
			margin-left: 15px;
		}

		.btna {
			background-color: #ffffff;
			width: 100%;
			border: solid 1px;
			border-radius: 5px;
			height: 40px;
			padding: 0px;
			padding-top: 5px;
			margin-bottom: 25px;
		}

		.btna:focus {
			box-shadow: none;
		}

		#menuAex table {
			width: 100%;
			margin-bottom: 10px;
			background-color: white;
		}

		#menuAex td {
			border: solid 1px;
			cursor: pointer;
		}

		.semanalmente {
			padding-bottom: 15px;
		}

		.data {
			border: solid 1px;
			border-radius: 5px;
		}

		.hr {
			border-radius: 5px;
		}

		.janela {
			width: 23px;
			height: 28px;
			margin-right: 5px;
			float: right;
		}

		#sair {
			background-color: #4b8fc3;
			color: white;
			border: none;
			padding-right: 2px;

		}

		#nome1 {
			width: 65%;
			margin-bottom: 25px;
			height: 30px;
			border-radius: 5px;
			border: solid 1px;
			font-weight: normal;
		}

		#usuperm {
			width: 30%;
			margin-bottom: 25px;
			height: 30px;
			border-radius: 5px;
			border: solid 1px;
			font-weight: normal;
		}

		#start {
			width: 100%;
			margin-bottom: 25px;
			height: 40px;
			border-radius: 5px;
			border: solid 1px;
		}

		.corbt {
			background-color: #3bff00;
		}

		.selecionado {
			background-color: #3bff00;
		}
	</style>
	<script>
		function aex() {
			var aex = document.getElementById("aex").value;
			if (aex == 1) {
				document.getElementById("aex").value = "2";
			} else {
				document.getElementById("aex").value = "1";
			}
		}

		function semanal(S) {
			var Dsemana = document.getElementById("s" + S);
			var sema = document.getElementById("d" + S);

			if (Dsemana.checked) {
				Dsemana.checked = false;
				sema.checked = false;
			} else {
				Dsemana.checked = true;
				sema.checked = true;
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
					<img class="d-none d-lg-block d-md-block  " src="../imagens/Logo.png" id="logo"/>
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



			<nav id="voltamsg" class="navbar navbar-expand-md navbar-light hidden-xs hidden-sm">
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
						<li class="nav-item">
							<a class="nav-link" href="../Home/Home.php">Home</a>
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
			<!-------------------------------------Agendamento--------------------------------------->
			<form action="logicgend.php" method="post">
				<div class="row">
					<div class="col-lg-8">
						<div class="alert alert-warning alert-dismissible" style="width: 70%; float: right; margin-left: 300px;">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Atenção!</strong> Certifique-se de escolher um horário não ocupado.
						</div>
						<div id="retornaagend">
						<div style="display:none; margin-left: 10px;" class="spinner-border"></div>
						</div>
						<div class="agendamento row">
							<div class="col-lg-12 col-md-12 col-sm-12">
								<div class="btn-group area">
									<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
										ÁREAS &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
									</button>
									<div class="dropdown-menu">
										<a onclick="salas(1)" class="dropdown-item">BLOCO B - 1º ANDAR</a>
										<a onclick="salas(2)" class="dropdown-item">BLOCO B - TÉRREO</a>
										<a onclick="salas(3)" class="dropdown-item">BLOCO C - 1º ANDAR</a>
										<a onclick="salas(4)" class="dropdown-item">BLOCO C - EXTENÇÃO</a>
										<a onclick="salas(5)" class="dropdown-item">BLOCO C - TÉRREO</a>
									</div>
									<input style="display:none;" value="BLOCO B - 1º ANDAR" id="area" type="text">
								</div>
								<select onchange="manutenção(this.value)" id="tipo" class="btn btn-primary">
									<option style="display: none;" value="Ensino">TIPO</option>
									<option value="Ensino">ENSINO</option>
									<?php if ($_SESSION["permissao"] == 3) {
										echo '<option value="Manutenção">MANUTENÇÃO</option>';
									} ?>
									<option value="Outros">OUTROS</option>
								</select>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-12">
								<fieldset class="agend1 agendborda">
									<legend style="margin-bottom: 20px;" class="legenda">
										<h4 id="legend">BLOCO B - 1º ANDAR</h4>
									</legend>
									<div id="salas1">
										<ul style="padding-left: 10px;">
											<input type="radio" id="lab1" name="labs" value="Comunicações"> <label class="labo" for="lab1">Comunicações</label> <br>
											<input type="radio" id="lab2" name="labs" value="Ópticas"> <label class="labo" for="lab2">Ópticas</label> <br>
											<input type="radio" id="lab3" name="labs" value="Lab. Programação I"> <label class="labo" for="lab3">Lab. Programação I</label> <br>
											<input type="radio" id="lab4" name="labs" value="Lab. Programação IV"> <label class="labo" for="lab4">Lab. Programação IV</label> <br>
											<input type="radio" id="lab5" name="labs" value="MPCE"> <label class="labo" for="lab5">MPCE</label> <br>
											<input type="radio" id="lab6" name="labs" value="Lab. Programação II"> <label class="labo" for="lab6">Lab. Programação II</label> <br>
											<input type="radio" id="lab7" name="labs" value="Lab. Programação III"> <label class="labo" for="lab7">Lab. Programação III</label> <br>
											<input type="radio" id="lab8" name="labs" value="Redes de Telecomunicações"> <label class="labo" for="lab8">Redes de Telecomunicações</label> <br>
											<input type="radio" id="lab9" name="labs" value="Sistemas de Telecom"> <label class="labo" for="lab9">Sistemas de Telecom</label> <br>
										</ul>
									</div>
									<div id="salas2" style="display: none;">
										<ul style="padding-left: 10px;">
											<input type="radio" id="lab1" name="labs" value="Indústria I"> <label class="labo" for="lab1">Indústria I</label> <br>
											<input type="radio" id="lab2" name="labs" value="Indústria II"> <label class="labo" for="lab2">Indústria II</label> <br>
											<input type="radio" id="lab3" name="labs" value="Indústria III"> <label class="labo" for="lab3">Indústria III</label> <br>
											<input type="radio" id="lab4" name="labs" value="Lab. FINEP"> <label class="labo" for="lab4">Lab. FINEP</label> <br>
										</ul>
									</div>
									<div id="salas3">

									</div>
									<div id="salas4" style="display: none;">
										<ul style="padding-left: 10px;">
											<input type="radio" id="lab1" name="labs" value="Lab. Robótica e Controle"> <label class="labo" for="lab1">Lab. Robótica e Controle</label> <br>
											<input type="radio" id="lab2" name="labs" value="Lab. de Acionamentos/CLP"> <label class="labo" for="lab2">Lab. de Acionamentos/CLP</label> <br>
											<input type="radio" id="lab3" name="labs" value="Lab. de Ele. de potência"> <label class="labo" for="lab3">Lab. de Ele. de potência</label> <br>
											<input type="radio" id="lab4" name="labs" value="Lab. Hidráulica/Pneumática"> <label class="labo" for="lab4">Lab. Hidráulica/Pneumática</label> <br>
										</ul>
									</div>
									<div id="salas5" style="display: none;">
										<ul style="padding-left: 10px;">
											<input type="radio" id="lab1" name="labs" value="Áudio e Vídeo"> <label class="labo" for="lab1">Áudio e Vídeo</label> <br>
											<input type="radio" id="lab2" name="labs" value="Lab. de Automação"> <label class="labo" for="lab2">Lab. de Automação</label> <br>
											<input type="radio" id="lab3" name="labs" value="CMDI MAKER"> <label class="labo" for="lab3">CMDI MAKER</label> <br>
											<input type="radio" id="lab4" name="labs" value="Lab. de Física"> <label class="labo" for="lab4">Lab. de Física</label> <br>
											<input type="radio" id="lab4" name="labs" value="Quimica"> <label class="labo" for="lab4">Quimica</label> <br>
										</ul>
									</div>

								</fieldset>
							</div>
							<div class="col-lg-6 col-md-5 col-sm-12">

								<div id="demo" class="carousel slide">

									<!-- The slideshow -->
									<div class="carousel-inner">
										<div class="carousel-item active">
											<fieldset class="agend2 agendborda">
												<legend class="legenda">
													<h4>ESPECIFICAÇÕES</h4>
												</legend>

												<label for="item1" class="filtro">AJUDANTE</label>
												<label class="switch">
													<input class="itens" value="Ajudante" name="item[]" type="checkbox" id="item1">
													<span class="slider round"></span>
												</label> <br>
												<label for="item2" class="filtro">MULTÍMETROS</label>
												<label class="switch">
													<input class="itens" value="Multímetros" name="item[]" type="checkbox" id="item2">
													<span class="slider round"></span>
												</label> <input placeholder="0" class="filtroN" id="n1" type="number"> <br>
												<label for="item3" class="filtro">DATA SHOW</label>
												<label class="switch">
													<input class="itens" value="Data show" name="item[]" type="checkbox" id="item3">
													<span class="slider round"></span>
												</label> <br>
												<label for="item4" class="filtro">CAIXA DE SOM</label>
												<label class="switch">
													<input class="itens" value="Caixa de som" name="item[]" type="checkbox" id="item4">
													<span class="slider round"></span>
												</label> <br>
												<label for="item5" class="filtro">CADEIRAS</label>
												<label class="switch">
													<input class="itens" value="Cadeiras" name="item[]" type="checkbox" id="item5">
													<span class="slider round"></span>
												</label> <input placeholder="0" id="n2" class="filtroN" type="number"> <br>
												<label for="item6" class="filtro">PROTOBOARDS</label>
												<label class="switch">
													<input class="itens" value="Protoboards" name="item[]" type="checkbox" id="item6">
													<span class="slider round"></span>
												</label> <input id="n3" placeholder="0" class="filtroN" type="number"> <br>
											</fieldset>
											<br> <br>
										</div>
										<div class="carousel-item">
											<fieldset class="agend2 agendborda">
												<legend class="legenda">
													<h4>COMENTÁRIOS</h4>
												</legend>
												<textarea id="coments" maxlength="300" placeholder="Adicionais" class="comentarios"></textarea>
											</fieldset>
											<br> <br>
										</div>
									</div>
									<!-- Indicators -->
									<ul class="carousel-indicators">
										<li data-target="#demo" data-slide-to="0" class="bola active"></li>
										<li data-target="#demo" data-slide-to="1" class="bola"></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-12 col-sm-12">
						<div class="agendamento text-center">
							<p style="font-size: 21px; color: #333333;">AGENDA</p>
							<div style="display: none;" id="manutenção">
								<label style="width: 50px; margin-left: 2%;" for="aex3">INÍCIO</label> <input value="" name="inicioM" class="data" id="am3" type="date"> <br>
								<label style="width: 50px; margin-left: 2%;" for="aex4">FIM</label> <input value="" name="fimM" class="data" id="am4" type="date"> <br>
							</div>
							<div id="Nmanutenção">
								<?php if ($_SESSION["permissao"] == 3) {
									echo '
								<label><strong>USUÁRIO</strong></label><br>
							<select name="permissao" id="usuperm">
								<option style="display:none;" value="">Permissão</option>
								<option value="1">Aluno</option>
								<option value="2">Professor</option>
								<option value="3">Administrador</option>
							</select>
							<input placeholder="Nome" value="" name="nome" type="text" id="nomeA">
								';
								} ?>
								<div id="dia">
									<label><strong>DIA</strong></label>
									<input name="dia" type="date" id="start">
								</div>
								<?php
								if ($_SESSION['permissao'] != 1) {
									echo '<div id="menuAex">
								<table>
									<tr>
										<td onclick="semanal(0)">Dom</td><Input style="display: none;" value="0" id="s0" type="checkbox" name="semanal[]"><Input style="display: none;" value="domingo" id="d0" type="checkbox" name="sema[]">
										<td onclick="semanal(1)">Seg</td><Input style="display: none;" value="1" id="s1" type="checkbox" name="semanal[]"><Input style="display: none;" value="segunda" id="d1" type="checkbox" name="sema[]">
										<td onclick="semanal(2)">Ter</td><Input style="display: none;" value="2" id="s2" type="checkbox" name="semanal[]"><Input style="display: none;" value="terça" id="d2" type="checkbox" name="sema[]">
										<td onclick="semanal(3)">Qua</td><Input style="display: none;" value="3" id="s3" type="checkbox" name="semanal[]"><Input style="display: none;" value="quarta" id="d3" type="checkbox" name="sema[]">
										<td onclick="semanal(4)">Qui</td><Input style="display: none;" value="4" id="s4" type="checkbox" name="semanal[]"><Input style="display: none;" value="quinta" id="d4" type="checkbox" name="sema[]">
										<td onclick="semanal(5)">Sex</td><Input style="display: none;" value="5" id="s5" type="checkbox" name="semanal[]"><Input style="display: none;" value="sexta" id="d5" type="checkbox" name="sema[]">
										<td onclick="semanal(6)">Sab</td><Input style="display: none;" value="6" id="s6" type="checkbox" name="semanal[]"><Input style="display: none;" value="sábado" id="d6" type="checkbox" name="sema[]">
									</tr>
								</table>
								
								<label style="width: 50px; margin-left: 2%;" for="aex3">INÍCIO</label> <input value="" name="inicioex" class="data" id="aex3" type="date"> <br>
								<label style="width: 50px; margin-left: 2%;" for="aex4">FIM</label> <input value="" name="fimex" class="data" id="aex4" type="date"> <br>

							</div>';
								}
								?>

								<label><strong>HORÁRIO</strong></label><br>
								<label style="width: 80px;" for="hr1"><strong>COMEÇO</strong></label><input name="começo" class="hr" id="hr1" type="time"><br>
								<label style="width: 80px;" for="hr2"><strong>TERMINO</strong></label><input name="termino" class="hr" id="hr2" type="time"> <br> <br>
								<?php
								if ($_SESSION['permissao'] != 1) {
									echo '<abbr title="Clique para agendar mais de um dia">
								<a onclick="aex()" id="btnaex" class="btn btna">
									<strong> REPETIR AGENDAMENTO</strong>
								</a>
							</abbr>';
								}
								?>
							</div>
							<br> <input style="display: none;" value="1" name="aex" type="text" id="aex">
							<a href="#voltamsg"><input id="agendar" type="button" value="AGENDAR" style="width: 100px; height: 41px; margin-bottom: 0px;" class="btna"></a>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<script>
		function manutenção(tipo) {
			if (tipo == "Manutenção") {
				document.getElementById("manutenção").style.display = "block"
				document.getElementById("Nmanutenção").style.display = "none"

			} else {
				document.getElementById("Nmanutenção").style.display = "block"
				document.getElementById("manutenção").style.display = "none"
			}
		}
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
		// muda cor do botao repetir agendamento
		$("#menuAex").hide();
		$(document).ready(function() {

			$("#agendar").click(function() {
				$(".spinner-border").show();
				var dados = new FormData();
				var area = document.getElementById("area").value;
				var tipo = document.getElementById("tipo").value;
				var labs = document.querySelector("input[name='labs']:checked").value;
				itens = [];
				$('.itens:checked').each(function(element) {
					itens.push($(this).val());
				});
				var coments = document.getElementById("coments").value;
				var dia = document.getElementById("start").value;
				var comeco = document.getElementById("hr1").value;
				var termino = document.getElementById("hr2").value;
				semanal = [];
				sema = [];
				$('input[name="semanal[]"]:checked').each(function(element) {
					semanal.push($(this).val());	
				});
				$('input[name="sema[]"]:checked').each(function(element) {
					sema.push($(this).val());	
				});
				semanal.serialize;
				var aex = document.getElementById("aex").value;
				if(tipo == "Manutenção"){
					var inicioM = document.getElementById("am3").value;
					var fimM = document.getElementById("am4").value;
					dados.append('inicioM', inicioM);
					dados.append('fimM', fimM);
				}
				<?php
					if($_SESSION["permissao"]==3){
						echo 'var nome = document.getElementById("nomeA").value;';
						echo 'var permissao = document.getElementById("usuperm").value;';
						echo "dados.append('permissao', permissao);";
						echo "dados.append('nome', nome);";
					}
					if($_SESSION["permissao"]!=1){
						echo 'var inicioex = document.getElementById("aex3").value;';
						echo 'var fimex = document.getElementById("aex4").value;';
						echo "dados.append('inicioex', inicioex);";
						echo "dados.append('fimex', fimex);";
					}
				?>

				dados.append('area', area);
				dados.append('labs', labs);
				dados.append('tipo', tipo);
				dados.append('item', itens);
				dados.append('coments', coments);
				dados.append('dia', dia);
				dados.append('começo', comeco);
				dados.append('termino', termino);
				dados.append('semanal', semanal);
				dados.append('sema', sema);
				dados.append('aex', aex);

				$.ajax({
					url: 'logicgend.php',
					method: 'post',
					data: dados,
					processData: false,
					contentType: false,
					success: function(resposta) {
						document.getElementById("retornaagend").innerHTML = resposta;
						$(".spinner-border").hide();
					}
				})
			})

			$("td").click(function() {
				$("#sema").text($(this).text())
			})

			$("#btnaex").mousedown(function() {
				$(this).toggleClass("corbt");
			})
			// funcionalidade do botão repetir agendamento
			$("#btnaex").click(function() {
				$("#dia").toggle();
				$("#menuAex").toggle();
			})
			// muda cor do dia da semana selecionado
			$("td").mousedown(function() {
				$(this).toggleClass("selecionado");
			})
			// atribui valor de area
			$(".area a").click(function() {
				$('#area').val($(this).text());
			});


			$("#n1").blur(function() {
				$('#item2').val($(this).val() + " Multímetros");
			});
			$("#n2").blur(function() {
				$('#item5').val($(this).val() + " Cadeiras");
			});
			$("#n3").blur(function() {
				$('#item6').val($(this).val() + " Protoboards");
			});
		});
	</script>

</body>

</html>
<!--
-->