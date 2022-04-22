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
			background-color: #3db244;
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
			<?php
			$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
			$servername = 'localhost';
			$username = 'root';
			$password = '';
			$database = 'cordlab';
			$mysqli = new mysqli($servername, $username, $password, $database);
			$consulta = $mysqli->query("SELECT * FROM usuarios WHERE id = '$id'");
			$result = $consulta->fetch_array();
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

			echo '<p style="display:none;" id="nome1">' . $result["nomecompleto"] . '</p>';
			echo '<p style="display:none;" id="email1">' . $result["email"] . '</p>';
			echo '<p style="display:none;" id="telefone1">' . $result["telefone"] . '</p>';
			echo '<p style="display:none;" id="senha1">' . $result["senha"] . '</p>';
			echo '<p style="display:none;" id="turma1">' . $result["turma"] . '</p>';
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
							<p>Tem certeza que deseja excluir o usuário <strong><?php echo $result["nomecompleto"]; ?></strong>? </p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
							<a href="Excluir.php?id=<?php echo $id; ?>" type="button" class="btn btn-danger">Excluir</a>
						</div>
					</div>
				</div>
			</div>

			<div style="padding: 10px;">
				<div class="cadastro">
					<h1 class="text-center" style="font-size: 30px;">Editar usuário</h1>
					<div class="row">
						<div class="card-body">
							<form method="post" action="editarlogic.php">
								<fieldset>
									<input name="id" value="<?php echo $id; ?>" style="display: none;" type="text">
									<input name="senha" value="<?php echo $result["senha"]; ?>" style="display: none;" type="password">
									<label class="rotulo" for="nome"> Nome Completo</label> <br>
									<input id="nome2" required class="campo" type="text" name="nome"> <br><br>
									<label class="rotulo" for="email"> Email</label> <br>
									<input id="email" required class="campo" type="E-mail" name="email"> <br><br>
									<label class="rotulo" for="telefone"> Telefone</label> <br>
									<input id="telefone" class="campo" type="tel" name="telefone"> <br><br>
									<label class="rotulo" for="Nsenha">Nova Senha</label> <br>
									<input id="senha" class="campo" type="password" name="Nsenha"> <br><br>
									<select id="permissao" class="campo" style="width: 100px; height: 30px; margin-right: 70%" name="permissão">
										<option value="<?php echo $result["permissão"]; ?>"><?php echo $permissão; ?></option>
										<option value="1">Aluno</option>
										<option value="2">Professor</option>
										<option value="3">Adiministrador</option>
									</select><br><br>
									<div id="turma" style="display: none;">
										<label class="rotulo" for="turma"> Curso</label> <br>
										<input value="" id="turm" class="campo" type="text" name="turma"> <br><br>
									</div>
									<div class="text-center">
										<input class="botao" type="submit" value="Salvar">
										<input onclick="cancela()" style="background-color: #FFA500;" class="botao" type="button" value="Cancelar">
										<input data-toggle="modal" data-target="#modalExclui" style="background-color: #B22222;" class="botao" type="button" value="Excluir">
										<br><br>
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

		function cancela() {
			window.location.href = "Usuarios.php";
		}

		$(document).ready(function() {
			$(':input').on('focus', function() {
				this.dataset.placeholder = this.placeholder;
				this.placeholder = '';
			}).on('blur', function() {
				this.placeholder = this.dataset.placeholder;
			});

			$("#nome2").val($("#nome1").text());

			$("#email").val($("#email1").text());

			$("#telefone").val($("#telefone1").text());
			$("#turm").val($("#turma1").text());
		})
	</script>

</body>

</html>