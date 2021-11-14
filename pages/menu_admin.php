<?php
session_start();
if(!isset($_SESSION["ADMIN"]) || $_SESSION["ADMIN"] <> 'S') {
  $url = "pages/login.html";
  header('Location: '.$url.' ');
  exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SolidaryPoints | Admin</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Rambla:wght@400;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            border: 0;
            
            font-family: 'Rambla', sans-serif;
        }
        body {
            display: flex;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;

            margin-left: 15rem;

            width: 100%;
        }
        aside {
            position: fixed;
            width: 13rem;
            height: 90vh;
            padding: 3rem 0rem 3rem 0rem;
            background-color: rgb(16, 10, 56);
            box-shadow: 0px 9px 11px rgba(0, 0, 0, 0.2), 0px 18px 28px rgba(0, 0, 0, 0.14);

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }
        .aside-title {
            font-size: 2rem;
            color: white;
        }
        .aside-button{
            display: flex;
            align-items: center;
            justify-content: center;

            width: 75px;
            height: 75px;

            border-radius: 50%;
            background: #F53838;

            box-shadow: 0px 8px 10px rgba(0, 0, 0, 0.2);

            cursor: pointer;
            transition: .5s;
        }
        .aside-button:hover {
            background: #bd1b1bbf;
            transition: .5s;
        }
        .aside-button img {
            width: 35px;
            height: 30px;
        }
        .cards-container {
            display: flex;
			justify-content: center;
			align-items: center;
			
			width: 100%;
			flex-wrap: wrap;
        }
        .card {
            box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2), 0px 6px 10px rgba(0, 0, 0, 0.14);

            border-radius: 20px;

            width: 224px;
            height: 150px;

            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;

            padding: 1rem 1rem;
			margin: 20px;
			
			transition: .5s;
			
			cursor: pointer;
        }
		.card:hover {
             transform: scale(1.1, 1.1);
			 transition: .5s;
        }
        .card a {
            color: #F53838;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
        }
        .card a:hover {
            text-decoration: underline;
        }
        footer {
            font-size: 8px;
            margin-top: 10px;
            margin-bottom: 10px;
			
			display: none;
        }
		.card-icon {
			width: 100px;
		}
		@media(max-width:811px){
			.cards-container {
				display: flex;
				justify-content: center;
				align-items: center;
				gap: 3rem;
				width: 50%;
			}
			.container {
				display: flex;
				flex-direction: column;
				align-items: center;
				margin-left: 10rem;
				width: 100%;
			}
		}
		@media(max-width:527px){
			.cards-container {
				display: flex;
				justify-content: center;
				align-items: center;
				gap: 3rem;
				width: 50%;
			}
			.container {
				display: flex;
				flex-direction: column;
				align-items: center;
				margin-left: 0rem;
				width: 100%;
			}
			aside {
				display: none;
			}
			footer {
				margin: 1rem 0rem 1rem 0rem;
				display: block;
			}
		}
		@media(max-width:403px){
			.cards-container {
				display: flex;
				justify-content: center;
				align-items: center;
				gap: 3rem;
				width: 50%;
			}
			.container {
				display: flex;
				flex-direction: column;
				align-items: center;
				width: 100%;
			}
			aside {
				display: none;
			}
		}
    </style>
</head>
<body>
    <aside>
        <h1 class="aside-title">
            Admin
        </h1>

        <section class="aside-button">
		<a href='index.php'>
            <img src="../images/back.svg" alt="Voltar">
		</a>
        </section>
    </aside>
    <main class="container"> 
        <header style="margin-top: 20px;">
            <img src="../images/logo.svg" alt="Logo SolidaryPoints">
        </header>
			<main class='cards-container'>
				<a href="aprov-feedbacks.php">
					<section class="card card1">
						<img src="../images/aprov-feedback.png" alt="" class="card-icon">
						<a href='aprov-feedbacks.php'>Aprovação de Feedbacks</a>
					</section>
				</a>
				<a href="suporte.php">
					<section class="card card1">
						<img src="../images/suporte.png" alt="" class="card-icon">
						<a href='suporte.php'>Análise de Suporte</a>
					</section>
				</a>
				<a href="pontos-sts.php">
					<section class="card card1">
						<img src="../images/monitorar-pontos.png" alt="" class="card-icon">
						<a href='pontos-sts.php'>Monitoração de Pontos</a>
					</section>
				</a>

			</main>
		<footer>
			<section class="aside-button">
			<a href='../../../../new_menu/demos/menu/siga_gestaopessoal.php'>
				<img src="../../assets/icons_ativos/back.svg" alt="Voltar">
			</a>
			</section>
		<footer>
       
    </main>
</body>
</html>