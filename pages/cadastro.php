<?php
	session_start();
	if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"] == 'S') {
		$hidden = "";
	}
	else {
		$hidden = "hidden";
	}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/cadastro.css">
    <title>Cadastro | SolidaryPoints</title>
		<link rel="shortcut icon" href="../images/big-logo.png" />
</head>
<body>
		<style>
			select {
				margin-top: 10px;
				color: black;
				width: 50%;
				padding: 8px;
			}
			select option {
				color: black;
				padding: 5px;
			}
		</style>
    <div class="blur"></div>
    <div class="ball1"></div>
    <div class="ball2"></div>
	<div class="wrapper">
		<header class="title_login">
			<h1 class="header_title">
				Vamos fazer o seu cadastro
			</h1>
			<h2 class="header_subtitle">
				Bem vindo(a) a nossa plataforma!
			</h2>
		</header>
		<form action='../script.php' method='post' target='_parent' autocomplete='off' class="inputs_form">
			<input type="hidden" name="visao" value="cadastro">
			<main class="inputs">
					<input id='first-name' class='input100' type='text' name='username' placeholder='Nome completo'>
        <div class="row1">
					<input id='contato' class='input100' type='text' name='contato' placeholder='DDD + Número de contato'>
					<input class='input100' type='text' name='cpf' placeholder='CPF'>
        </div>
				<div class="row1">
					<input style="flex:2;" id='endereco' class='input100' type='text' name='endereco' placeholder='Endereço'>
					<input style="flex:1;" class='input100' type='text' name='numero' placeholder='Número'>
        </div>
        <br>
					<input id='email' class='input100' type='email' name='email' placeholder='Email'>
					<input class='input100' type='password' name='pass' placeholder='Digite a Senha'>
					<label <?php echo $hidden; ?> for="is_admin">Administrador: </label>
					<select <?php echo $hidden; ?> name="is_admin" id="is_admin">
						<option value="S">Sim</option>
						<option selected value="N">Não</option>
					</select>
			</main>
			<footer class="footer_login">
				<button type="submit" class="login_button">
					Cadastrar
				</button>
			</footer>
		</form>
		 <img style="position: absolute; top: 0px; right: 15px; margin-top:30px;"width="100px" src="../images/logo.svg" alt="Logo da Atendti">
	</div>
    <img src="../images/big-logo.png" alt="Equipe Trabalhando" class='bg-equipe'>
</body>
</html>

