<?php
session_start();
if (!(isset($_SESSION['permissao']))) {
	header('location: ../Login/login.php');
} else {
	if ($_SESSION['permissao'] != 3)
		header('location: ../Login/login.php');
}
if (isset($_POST['sair'])) {
	unset(
		$_SESSION['usuario'],
		$_SESSION['permissao']
	);
	header('location: ../Login/login.php');
}
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

	<style>
		/*----------------------------------------Cadastro---------------------------------------*/
		.cadastro {
			background-color: rgba(189, 185, 185, 0.3);
			max-width: 600px;
			min-width: 30vh;
			border: solid 1px;
			margin: 0 auto;
			margin-top: 10%;
			margin-bottom: 10%;
			border-radius: 5px;
		}

		.rotulo {
			width: 30%;
			height: 5px;
			margin-left: 3%;
			margin-top: 2%;
			font-size: 19px;
		}

		.campo {
			width: 90%;
			height: 25px;
			margin-left: 3%;
			border: solid 1px;
			border-radius: 5px;
		}

		.botao {
			width: 90px;
			height: 32px;
			background-color: rgba(78, 214, 86, 0.8);
			border: solid 1px;
			border-radius: 5px;
		}

		#sair {
			background-color: #4b8fc3;
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
						<li class="nav-item">
							<a class="nav-link" href="../Usuarios/Usuarios.php">Usuários</a>
						</li>
					</ul>
				</div>
			</nav>

			<!-------------------------------------Miolo do site--------------------------------------->
			<div style="padding: 10px;">
				<div class="cadastro">
					<h1 class="text-center" style="font-size: 30px;">Cadastro</h1>
					<?php
					if (isset($_SESSION['msgemail'])) {
						echo $_SESSION['msgemail'];
						unset($_SESSION['msgemail']);
					}
					?>
					<?php
					if (isset($_SESSION['msg'])) {
						echo $_SESSION['msg'];
						unset($_SESSION['msg']);
					}
					?>
					<div class="row">
						<div class="card-body">
							<form method="post" action="Cadastrologic.php">
								<fieldset>
									<label class="rotulo" for="nome"> Nome Completo</label> <br>
									<input required class="campo" type="text" name="nome"> <br><br>
									<label class="rotulo" for="email"> Email</label> <br>
									<input required class="campo" type="E-mail" name="email"> <br><br>
									<label class="rotulo" for="telefone"> Telefone</label> <br>
									<input class="campo" type="tel" name="telefone"> <br><br>
									<label class="rotulo" for="senha"> Senha</label> <br>
									<input required class="campo" type="password" name="senha"> <br><br>
									<select id="permissao" class="campo" style="width: 100px; height: 30px; margin-right: 70%" name="permissão">
										<option value="0">Permissão</option>
										<option value="1">Aluno</option>
										<option value="2">Professor</option>
										<option value="3">Adiministrador</option>
									</select><br><br>
									<div id="turma" style="display: none;">
										<label class="rotulo" for="turma"> Curso</label> <br>
										<input id="turm" class="campo" type="text" name="turma"> <br><br>
									</div>
									<div class="text-center">
										<input class="botao" type="submit" value="Cadastrar"> <br><br>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		function ativaturma() {
			var permissao = document.getElementById('permissao').value;
			if (permissao == '1') {
				document.getElementById('turma').style.display = 'block';
				document.getElementById("turm").setAttribute('required', this.value == 'req');
			} else {
				document.getElementById('turma').style.display = 'none';
				document.getElementById("turm").removeAttribute('required');
			}
		}
		setInterval(function() {
			ativaturma();
		}, 1);
	</script>

</body>

</html>