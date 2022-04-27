<?php
session_start();
if (!(isset($_SESSION['permissao']))) {
	header('location: ../../Login/login.php');
} else {
	if ($_SESSION['permissao'] != 3)
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
			background-color: #658095;
			border: solid 1px;
			border-radius: 5px;
		}

		.botao1 {
			width: 120px;
			height: 32px;
			background-color: rgba(189, 185, 185, 0.8);
			border: solid 1px;
			border-radius: 5px;
			margin-left: 20px;
			color: black;
			padding: 5px;
		}

		.botao1:hover {
			color: black;
		}


		#sair {
			background-color: #4b8fc3;
			color: white;
			border: none;
			padding-right: 2px;

		}

		::-webkit-input-placeholder {
			color: black;
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
						<img class="d-none d-lg-block d-md-block  " src="../../imagens/Logo.png" id="logo" />
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
							<img src="../../imagens/login.png" id="login" />
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
						<li class="nav-item">
							<a class="nav-link" href="../../Usuarios/Usuarios.php">Usuários</a>
						</li>
					</ul>
				</div>
			</nav>

			<!-------------------------------------Miolo do site--------------------------------------->
			<?php
			$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
			$servername = 'localhost';
			$username = 'root';
			$password = '';
			$database = 'cordlab';
			$mysqli = new mysqli($servername, $username, $password, $database);
			$consulta = $mysqli->query("SELECT * FROM agendamentos WHERE id = '$id'");
			$result = $consulta->fetch_array();

			echo '<p style="display:none;" id="nome1">' . $result["nomecompleto"] . '</p>';
			echo '<p style="display:none;" id="permissao1">' . $result["Permissão"] . '</p>';
			echo '<p style="display:none;" id="area1">' . $result["Area"] . '</p>';
			echo '<p style="display:none;" id="sala1">' . $result["Sala"] . '</p>';
			echo '<p style="display:none;" id="data1">' . $result["Dia"] . '</p>';
			echo '<p style="display:none;" id="comeco1">' . $result["Comeco"] . '</p>';
			echo '<p style="display:none;" id="termino1">' . $result["Termino"] . '</p>';
			echo '<p style="display:none;" id="tipo1">' . $result["Tipo"] . '</p>';
			echo '<p style="display:none;" id="espec1">' . $result["Especificações"] . '</p>';
			echo '<p style="display:none;" id="coments1">' . $result["Coments"] . '</p>';
			echo '<p style="display:none;" id="usuario1">' . $result["Usuario"] . '</p>';
			echo '<p style="display:none;" id="atualizacao1">' . $result["reg_date"] . '</p>';
			?>
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
							<p>Tem certeza que deseja excluir todos os dias deste agendamento? </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a href="Excluir/Excluir1.php?id=<?php echo $id; ?>" type="button" class="btn btn-danger">Excluir</a>
						</div>
					</div>
				</div>
			</div>

			<div style="padding: 10px;">
				<div class="cadastro">
					<h1 class="text-center" style="font-size: 30px;">Editar agendamento</h1>
					<?php
					if (isset($_SESSION['agendsucess'])) {
						echo $_SESSION['agendsucess'];
						unset($_SESSION['agendsucess']);
					}
					?>
					<?php
					if (isset($_SESSION['agenderro2'])) {
						echo $_SESSION['agenderro2'];
						unset($_SESSION['agenderro2']);
					}
					?>
					<?php
					if (isset($_SESSION['agenderro1'])) {
						echo $_SESSION['agenderro1'];
						unset($_SESSION['agenderro1']);
					}
					?>
					<div class="row">
						<div class="card-body">
							<form method="post" action="editarlogic2.php">
								<fieldset id="editar" disabled>
									<input name="id" value="<?php echo $id; ?>" style="display: none;" type="text">
									<label class="rotulo" for="nome"> Agendado para:</label> <br>
									<select name="permissão" id="permissao" style=" width: 20%;" class="campo">
										<option value="1">Aluno</option>
										<option value="2">Professor</option>
										<option value="3">Administrador</option>
									</select>
									<input style="margin-left:0px; width: 69%;" id="nome2" required class="campo" type="text" name="nome"> <br>

									<label for="area" class="rotulo">Área</label><br>
									<select id="area" class="campo" name="area">
										<option value="BLOCO B - 1º ANDAR">BLOCO B - 1º ANDAR</option>
										<option value="BLOCO B - TÉRREO">BLOCO B - TÉRREO</option>
										<option value="BLOCO C - 1º ANDAR">BLOCO C - 1º ANDAR</option>
										<option value="BLOCO C - EXTENÇÃO">BLOCO C - EXTENÇÃO</option>
										<option value="BLOCO C - TÉRREO">BLOCO C - TÉRREO</option>
									</select><br>

									<label class="rotulo" for="sala"> Sala</label> <br>
									<select id="sala" class="campo" name="sala">
										<option disabled>BLOCO B - 1º ANDAR</option>
										<option value="Comunicações">Comunicações</option>
										<option value="Ópticas">Ópticas</option>
										<option value="Lab. Programação I">Lab. Programação I</option>
										<option value="Lab. Programação IV">Lab. Programação IV</option>
										<option value="MPCE">MPCE</option>
										<option value="Lab. Programação II">Lab. Programação II</option>
										<option value="Lab. Programação III">Lab. Programação III</option>
										<option value="Redes de Telecomunicações">Redes de Telecomunicações</option>
										<option value="Sistemas de Telecom">Sistemas de Telecom</option>

										<option disabled>BLOCO B - TÉRREO</option>
										<option value="Indústria I">Indústria I</option>
										<option value="Indústria II">Indústria II</option>
										<option value="Indústria III">Indústria III</option>
										<option value="Lab. FINEP">Lab. FINEP</option>

										<option disabled>BLOCO C - EXTENÇÃO</option>
										<option value="Lab. Robótica e Controle">Lab. Robótica e Controle</option>
										<option value="Lab. de Acionamentos/CLP">Lab. de Acionamentos/CLP</option>
										<option value="Lab. de Ele. de potência">Lab. de Ele. de potência</option>
										<option value="Lab. Hidráulica/Pneumática">Lab. Hidráulica/Pneumática</option>
										<option disabled>BLOCO C - TÉRREO</option>
										<option value="Áudio e Vídeo">Áudio e Vídeo</option>
										<option value="Lab. de Automação">Lab. de Automação</option>
										<option value="CMDI MAKER">CMDI MAKER</option>
										<option value="Lab. de Física">Lab. de Física</option>
										<option value="Quimica">Quimica</option>

									</select><br>

									<label class="rotulo" for="data"> Dia</label> <br>
									<input required id="data" class="campo" type="date" name="data"> <br>

									<label class="rotulo" for="comeco">Começo</label> <br>
									<input required id="comeco" class="campo" type="time" name="comeco"> <br>

									<label class="rotulo" for="termino">Termino</label> <br>
									<input required id="termino" class="campo" type="time" name="termino"> <br>

									<label class="rotulo" for="tipo">Tipo</label> <br>
									<select disabled name="tipo" id="tipo" class="campo">
										<option value="Ensino">Ensino</option>
										<option value="Manutenção">Manutenção</option>
										<option value="Outros">Outros</option>
									</select><br>
									<label class="rotulo" for="espec">Especificações</label> <br>
									<textarea style="height: 50px;" id="espec" class="campo" type="text" name="espec"></textarea> <br>

									<label class="rotulo" for="coments">Comentários</label> <br>
									<textarea style="height: 100px;" id="coments" class="campo" type="" name="coments"></textarea> <br>

									<label class="rotulo" for="usuario">Reservado por:</label> <br>
									<input disabled id="usuario" class="campo" type="text" name="usuario"> <br>

									<label class="rotulo" for="atualizacao">Última atualização</label> <br>
									<input disabled id="atualizacao" class="campo" type="text" name="atualizacao"> <br><br>

									<?php
									$pieces = explode("-", $result["InicioEx"]);
									$pieces1 = explode("-", $result["FimEx"]);
									if ($result['InicioEx'] != '') {
										echo '<p style="margin-left:20px; font-size:20px;">De: ' . $pieces[2] . '/' . $pieces[1] . '/' . $pieces[0] . ' Até: ' . $pieces1[2] . '/' . $pieces1[1] . '/' . $pieces1[0] . '</p>';
									}
									if ($result['Tipo'] == 'Manutenção') {
										echo '<a style="width:100px;" href="Manutencao.php?inicio=' . $result["InicioEx"] . '&fim=' . $result["FimEx"] . '&sala=' . $result["Sala"] . '"  class="botao1">Agendamentos neste período</a><br><br>';
									}
									if ($result['Semanal'] != '') {
										echo '<p style="margin-left:20px; font-size:20px;">Agendamento repetido: ' . $result['Semanal'] . '</p>';
										echo '<a href="Exrelatorio.php?id=' . $id . '"  class="botao1">Mostrar todos</a><br><br>';
									}
									?>
								</fieldset>

								<div class="text-center">
									<?php
									if ($result['Tipo'] != 'Manutenção') {
										echo '<input id="edita" class="botao" type="button" value="Editar">';
									}
									?>
									<input id="salva" style="display: none;" class="botao" type="submit" value="Salvar">
									<input onclick="cancela()" style="background-color: #538ab5;" class="botao" type="button" value="Sair">
									<input data-toggle="modal" data-target="#modalExclui" style="background-color: #365d76;" class="botao" type="button" value="Excluir">
									<br><br>

								</div>
							</form>
						</div>
					</div>
				</div>
			</div>


		</div>
	</div>
	<script>
		function cancela() {
			window.location.href = "../Home.php";
		}

		function mostra() {
			window.location.href = "Exrelatorio.php";
		}

		$(document).ready(function() {

			$("#edita").click(function() {
				$("#salva").show();
				$(this).hide();
				$("#editar").removeAttr('disabled');
			})
			$(':input').on('focus', function() {
				this.dataset.placeholder = this.placeholder;
				this.placeholder = '';
			}).on('blur', function() {
				this.placeholder = this.dataset.placeholder;
			});

			$("#nome2").val($("#nome1").text());
			$("#permissao").val($("#permissao1").text());
			$("#area").val($("#area1").text());
			$("#sala").val($("#sala1").text());
			$("#data").val($("#data1").text());
			$("#inicioex").val($("#inicioex1").text());
			$("#fimex").val($("#fimex1").text());
			$("#comeco").val($("#comeco1").text());
			$("#termino").val($("#termino1").text());
			$("#tipo").val($("#tipo1").text());
			$("#espec").val($("#espec1").text());
			$("#coments").val($("#coments1").text());
			$("#usuario").val($("#usuario1").text());
			$("#atualizacao").val($("#atualizacao1").text());
		})
	</script>

</body>

</html>