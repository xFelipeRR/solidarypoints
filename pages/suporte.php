<?php 
// if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
// 	unset($_SESSION['login']);
// 	unset($_SESSION['senha']);
// 	header('location:'.PHPGRID_URL.'/login.php');
// } 

$xScript = '';
$cardSuporte = '';
$conn = mysqli_connect("localhost","root","", "solidarypoints");
function DataBr($data){
	if(!empty($data)) {
		return date("d/m/Y", strtotime($data));
	}
	else {
		return '-';
	}
}

// $query = "
//   SELECT NOME FROM USUARIOS WHERE ID = ".$_SESSION['ID_USUARIO']."
// ";
// $result = $conn->query($query);
// while($row = $result->fetch_array()){
//   $nome
// }
session_start();
if(isset($_SESSION['ID_USUARIO'])) {
  $cHtml = "<li style='border-bottom: 1px solid #F53838; '><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="contato.php"><b>Entre</b></a></li> <li><a class="item-cadastro" href="contato.php">Cadastre-se</a></li>';
}

if(!isset($_SESSION["ADMIN"]) || $_SESSION["ADMIN"] <> 'S') {
  $url = "pages/login.html";
  header('Location: '.$url.' ');
  exit();
}

$query = "
  SELECT S.*,USR.NOME,USR.CONTATO FROM SUPORTE S
  LEFT OUTER JOIN USUARIOS USR ON(USR.ID = S.USUARIO)
  WHERE S.STS = 'A'
";
$result = $conn->query($query);
while($row = $result->fetch_array()){
  $mensagem = '(Atendimento SolidaryPoints) Resposta:%0A ---- Suporte ID('.$row["ID"].') ------------------------- %0A'.$row["MENSAGEM"].'%0A';
  $cardSuporte .= '
    <li class="splide__slide">
    <div class="beneficiado-card">
      <div class="beneficiado-intern">
        <div class="img-name-slider">
          <img src="../images/person-icon.svg">
          <h4 class="slider-title">'.$row["NOME"].'</h4>
        </div>
        
        <div class="slider-description">
        '.$row["MENSAGEM"].'
        </div>
        <div class="slider-forms">
          <form>
            <a href="https://api.whatsapp.com/send?phone=5585996262259&text='.$mensagem.'"><img width="50px" src="../images/whatsapp-icon.png"></a>
          </form>
          <form action="../script.php" method="POST">
            <input hidden name="visao" value="finaliza_suporte">
            <input hidden name="id_suporte" value="'.$row["ID"].'">
            <button class="form-btn btn-aprova">Finalizar</button>
          </form>
        </div> 
        <p class="feedback-date">'.DataBr($row["DT"]).'</p>
      </div>
    </div>
  </li>
  ';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suporte | SolidaryPoints</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link rel="stylesheet" href="../styles/start.css">
    <link rel="stylesheet" href="../styles/beneficiados.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script defer src="../node_modules/@splidejs/splide/dist/js/splide.min.js"></script>
    <link rel="stylesheet" href="../node_modules/@splidejs/splide/dist/css/splide.min.css">
    <link rel="stylesheet" href="../node_modules/@splidejs/splide/dist/css/themes/splide-sea-green.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
</head>
<body onload="sliderPerPage()">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700&display=swap');
    *{
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Rubik', sans-serif;
      font-size: 16px;
      text-decoration: none;
    }
    .all-container {
      width: 100%;
      height: 1000px;
      margin: auto;
      position: relative;
      top: 100px;
    }
    @media (max-width: 1000px) {
      .all-container {
        margin-top: 180px;
    }
}
    #mapid {
      height: 450px;
      z-index: 1;
    }
    .start-description-container {
      margin-top: 20px;
    }
    .align-div {
      width: 100%;
    }
    .slider-forms {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 30px;
    }
    .form-btn {
      outline: none;
      border: 1px solid white;
      padding: 10px;
      color: white;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
    }
    .btn-cancela {
      background: #db3636;
    }
    .btn-cancela:hover {
      background: #d72c2c;
    }
    .btn-aprova {
      background: #36db78;
    }
    .btn-aprova:hover {
      background: #18cb60;
    }
    .feedback-date {
      width: 100%;
      text-align: center;
      margin-top: 10px;
    }

  </style>
    <div id="wrapper">
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
                <a style="border-bottom: 1px solid #F53838; " href="index.php">Home</a>
              </li>
              <li>
                <a href="quem-somos.php">Sobre</a>
              </li>
              <li>
                <a href="pontos.php">Pontos</a>
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
          
          <div style="background: white!important;" class="start-wrapper">
            <div class="align-div">
              <div class="start-description-container">
                <h2 class="title start">Suporte</h2>
                <p style="margin-top: -20px" class="description start">
                  Analise os pedidos de ajuda e os responda com sua devida resolução
                </p>
              </div>
            
              <div id="card-slider" class="splide">
                <div class="splide__track">
                    <ul class="splide__list">
                      <?php echo $cardSuporte; ?>
                  </ul>
                </div>
              </div>

            </div>
          </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
      </div>
    </div>

    <script>
      
      let perPageValue = 0;
      let screenWidth = screen.width;

      
      if(screenWidth > 1000) {
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#card-slider', {
                perPage  : 3,
                //trimSpace: false,
                width: '100vw',
                rewind: true,
                breakpoints: {
                    1900: {
                        perPage: 3,
                    }
                },
            } ).mount();
        } );
      }
      else {
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#card-slider', {
                perPage  : 1,
                //trimSpace: false,
                width: '100vw',
                rewind: true,
                breakpoints: {
                    1900: {
                        perPage: 1,
                    }
                },
            } ).mount();
        } );
      }
   </script>
</body>
</html>