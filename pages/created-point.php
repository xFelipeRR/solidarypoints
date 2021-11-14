<?php
    session_start();
    if(isset($_SESSION['ID_USUARIO'])) {
        $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
    }
    else {
        $cHtml = '<li><a href="contato.php"><b>Entre</b></a></li> <li><a class="item-cadastro" href="contato.php">Cadastre-se</a></li>';
    }

    if(isset($_GET["erro"])) {
        $titulo = "Erro na Criação!";
        $subtitulo = "Parece que você já tem um ponto em aberto, termine o processo atual para poder continuar";
    }
    else {
        $titulo = "Ponto Criado!";
        $subtitulo = "Seu ponto foi criado com sucesso! Nossos administradores devem entrar em contato logo, muito obrigado!";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ponto Criado | SolidaryPoints</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Chivo&display=swap" rel="stylesheet"> 
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Asap:wght@700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<style>
body{
    background: white;
}
button {
	background: transparent;
	border: 0;
	font-size: 1.5rem;
}
.all-container{
    height: 85vh;
    margin-top: 10px;
	display: flex;
    justify-content: center;
    align-items: center;
}

.section{
    background: #0B132A;
    width: 70%;

    display: flex;
    justify-content: space-around;
    align-items: center;

    margin: 50px auto 10px auto;
    height: 440px;

    font-family: 'DM Sans', sans-serif;
    font-size: 36px;
    text-align: center;
}
.img-header{
    width: 7%;
}
.info{
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
}
.second{
    width: 90%;
    font-size: 0.5em;
    font-family: 'Chivo', sans-serif;
}
a{
	text-decoration: none;
}
.glyphicon{
	width: 30px;
	color: green;
}
/*Linha definida no arquivo bootstrap e atrapalha o menu
.collapse:not(.show){
	display: none!important;
}
*/
.btn-imp{
	display: flex;
	justify-content: center;
	align-items: center;
	
	cursor: pointer;
}
.btn_finalizar{
	width: 20%;
	min-width: 200px;
	height: 50px;
	margin-top: -25px;
	text-align: center;
	
	text-decoration: none;
	outline: none !important;
	border: 0;
	cursor: pointer;
	font-family: 'DM Sans', sans-serif;
	font-style: normal;
	font-weight: 500;
	font-size: clamp(8px,14px,16px);
	line-height: 27px;
	text-align: center;
	
	display: flex;
    align-items: center;
    justify-content: center;
	

	color: #EEEAEA;

	background: #DE2F17;
}
.btn_finalizar:hover{
	transition: 0.2s;
	background: #c20e0e;
}
.link_finalizar{
	text-decoration: none;
	outline: none !important;
	color: black;
	border: none;
	background: transparent;
	
	cursor: pointer;
}
.link_finalizar:hover{
	color: black;
	text-decoration: none;
}
nav.py-3 {
    padding: 10px!important;
    top: 0px;
}
.linkCatalogo {
	    margin: 1rem 0 0 4rem;
		font-size: 1.5rem;
}
.bug{
	display: flex;
	align-items: center;
}

@media (min-width: 100px) and (max-width: 610px){
    .section{
        height: 50vh;

        font-family: 'DM Sans', sans-serif;
        font-size: 25px;
        text-align: center;
		width: 90%;
    }
    .second{
        font-size: 20px;
    }
	.logo{
		margin-top: 4px;
		width:24px;
		height:24px;
	}
	.nav-item:first-child{
		padding-top: 40px!important;
	}
	.divslide{
		font-size: 10px;
		margin-left: 20px;
		margin-top: -70px!important;
	}
	.back button{
		width: 35px;
	}
	.backSpan{
		opacity:0;
	}
}
@media (min-height: 100px) and (max-height: 550px){
	.section{
    height: 220px;

    font-family: 'DM Sans', sans-serif;
    font-size: 18px;
    text-align: center;
		width: 90%;
		margin-top: 200px;
    }
	.btn_finalizar{
		margin-top: 105px;
	}
	.second{
		font-size: 15px;
	}
}
p {
	color: #ffffffd9;
}


</style>

    <div class="all-container">
        <nav>
          <div class="navbar">
            <i class='bx bx-menu'></i>
            <div class="logo"><img src="../images/logo.svg"></div>
              <div class="nav-links">
                  <div class="sidebar-logo">
                  <span class="logo-name"><img src="../images/logo.svg"></span>
                  <i class='bx bx-x' ></i>
                  </div>
                  <ul class="links">
                  <li>
                      <a href="index.php">Home</a>
                  </li>
                  <li>
                      <a href="quem-somos.php">Sobre</a>
                  </li>
                  <li>
                      <a style="border-bottom: 1px solid #F53838; " href="pontos.html">Pontos</a>
                  </li>
                  <li>
                      <a href="meu_perfil.php">Perfil</a>
                  </li>
                  
                  <li><a href="feedback.php">Feedback</a></li>

                  <li><a href="help.php">Ajuda</a></li>

                  <li><a style="display: flex;" href="full-map.php">Mapa &nbsp;<img width="25px" src="../images/map-icon.svg"></a></li>
                  
                  <?php echo $cHtml; ?>
                  </ul>
              </div>
              <div class="search-box">
                  <i style="display: none;" class='bx bx-search'></i>
                  <div class="input-box">
                  <input type="text" placeholder="Search...">
                  </div>
              </div>
          </div>
        </nav>
        <div class="section">
            <div class="info">
                <p><?php echo $titulo; ?></i></p>
				<img width="120px" src="../images/ok.png">
                <br>
                <p class="second"><?php echo $subtitulo; ?></p>
            </div>
        </div>
    </div>
	<div class="btn-imp">
		<a href="index.php">
			<div class="btn_finalizar">
				<button class="link_finalizar">Voltar</button>
			</div>
		</a>
	</div>

</body>
</html>