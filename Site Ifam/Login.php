<?php
session_start();
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
	<style>
		/*----------------------------------------Login---------------------------------------*/
.cadastro {
  background-color: rgba(189, 185, 185, 0.3);
  max-width: 600px;
  min-width: 30vh;
  border:solid 1px;
  margin: 0 auto;
  margin-top:10% ;
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
  border:solid 1px;
  border-radius: 5px;
}
.botao {
  width: 90px;
  height: 32px;
  background-color: rgba(78, 214, 86, 0.8);
  border:solid 1px;
  border-radius: 5px;
}
#login {
  width: 140px;
  height: 80px;
  margin-top: 17px;
  margin-bottom: 6px;
  margin-right: 0px;
  float: right;
  align-content: center;
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
					<img class="d-none d-lg-block d-md-block  " src="imagens/logoifam.png" id="logo"/>
				</div>
				<div class="col-12 col-lg-9 col-md-9 col-sm-12 text-center">
					<p class="tema">Reserva de Laboratórios</p>
					<p class="subtitulo">Campus Manaus Distrito Industrial</p>
				</div>
				<!-- (futura implementação, nesta tela, a barra de pesquisa deve levar a
                    de laboratorios)
                    <div class="col-3 col-lg-3 col-md-4 d-none d-lg-block d-md-block">
                        <div id="divBusca">
                            <input type="search" class="txtBusca" />
                            <img src="imagens/lupa.png" id="btnBusca" alt="Buscar" />
                        </div>
                    </div>
                    -->
				 <div class="col-1 col-md-1 d-none d-lg-block d-md-block">
					 <img src="imagens/login.png" id="login" />
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
	 		 
		</nav>
		
<!-------------------------------------Miolo do site--------------------------------------->		
	<div style="padding: 10px;">
		<div class="cadastro container-fluid">
			<h1 class="text-center" style="font-size: 30px;">Login</h1>
			<div class="row">
			<div class="card-body">
			<?php
					if(isset($_SESSION['erroemail'])){
						echo $_SESSION['erroemail'];
						unset($_SESSION['erroemail']);
					}
				?>
			<?php
					if(isset($_SESSION['errosenha'])){
						echo $_SESSION['errosenha'];
						unset($_SESSION['errosenha']);
					}
				?>
			<form method="post" action="servidor/Loginlogic.php">
			  <fieldset>
			  
			   
			    <label class="rotulo" for="email"> Email</label> <br>
			    <input required class="campo" type="E-mail" name="email"> <br><br>
			    <label class="rotulo" for="senha"> Senha</label> <br>
			    <input required class="campo" type="senha" name="senha"> <br><br>
				<div class="text-center">
			    	<input class="botao" type="submit" value="Entrar"> <br>
					<a href="Homevisit.php"><u>Entrar como visitante</u></a><br>
				</div>		
			  </fieldset>
			</form>
			</div>
			</div>
		</div>
	</div>
	</div>
</div>
</body>
</html>