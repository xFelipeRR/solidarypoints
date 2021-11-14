<?php 
// if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
// 	unset($_SESSION['login']);
// 	unset($_SESSION['senha']);
// 	header('location:'.PHPGRID_URL.'/login.php');
// } 

$admin_menu_icon = "";
$onlyAdmin = "";
$cardFeedback = '';
$xScript = '';
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
  $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="login.html"><b>Entre</b></a></li> <li><a class="item-cadastro" href="cadastro.php">Cadastre-se</a></li>';
}

if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"] == 'S') {
  $btnActive = "submit";
  $styleDisabled = "style='background: whitesmoke;'";
  $onlyAdmin = "";
  $admin_menu_icon = '<li class="menu_admin"><a href="menu_admin.php"><img width="30px" src="../images/admin.png" alt="Administradores"></a></li>';
}
else {
  $btnActive = "button";
  $styleDisabled = "style='background: #b7b7b7; opacity: .8'";
  $onlyAdmin = "onclick='onlyAdmin()'";
  $admin_menu_icon = "";
}


$query = "
  SELECT P.ID,P.DESCRICAO,P.LATLNG,P.STS,P.TP_PONTO,P.CATEGORIAS,USR.NOME,USR.ENDERECO, USR.NUMERO,DT FROM PONTOS P
  LEFT OUTER JOIN USUARIOS USR ON (USR.ID = P.USUARIO)
  WHERE P.STS = 'A'
  AND P.TP_PONTO = 'DI'
  OR P.TP_PONTO = 'CO'
";

//echo $query;
$markers = '';
$result = $conn->query($query);
while($row = $result->fetch_array()){
  if($row["TP_PONTO"] == 'DI') {
    $markers .= "
    L.marker([".$row['LATLNG']."], {icon: yellowIcon}).addTo(map)
    ";
  }
  else {
    $markers .= "
    L.marker([".$row['LATLNG']."], {icon: blueIcon}).addTo(map)
    ";
  }
}

$query = "
  SELECT F.*,USR.NOME FROM FEEDBACK F
  LEFT OUTER JOIN USUARIOS USR ON(USR.ID = F.USUARIO)
  WHERE F.STS = 'A'
";
$result = $conn->query($query);
while($row = $result->fetch_array()){
  $cardFeedback .= '
    <li class="splide__slide">
    <a class="beneficiado-card">
      <div class="beneficiado-intern">
        <div class="img-name-slider">
          <img src="../images/person-icon.svg">
          <h4 class="slider-title">'.$row["NOME"].'</h4>
        </div>
        
        <div class="slider-description">
        '.$row["MENSAGEM"].'
        </div>
        <p class="feedback-date">'.DataBr($row["DT"]).'</p>
      </div>
    </a>
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
    <title>Menu | SolidaryPoints</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link rel="stylesheet" href="../styles/presentation.css">
    <link rel="stylesheet" href="../styles/benefits.css">
    <link rel="stylesheet" href="../styles/start.css">
    <link rel="stylesheet" href="../styles/beneficiados.css">
    <link rel="stylesheet" href="../styles/footer.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
    crossorigin=""></script>
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
    .feedback-date {
      width: 100%;
      text-align: center;
      margin-top: 10px;
    }
    .menu_admin {
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .start-conditions {
      height: 330px;
    }
    .point-img {
      width: 40px!important;
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
                <a style="border-bottom: 1px solid #F53838; " href="index.html">Home</a>
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
              <?php echo $admin_menu_icon; ?>
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
      <div class="all-container">
        <!--Apresentação-->
        <div class="align-div">
          <div class="presentation-wrapper">
            <div class="presentation-description-container">
              <h2 class="title presentation">Nosso foco é implementar a solidariedade</h2>
              <p class="description presentation">
                Trabalhando juntos, podemos melhorar muito a convivência nas cidades, por meio do desenvolvimento da empatia e o espírito solidário na população
              </p>
              <a href="quem-somos.php" class="button-form-presentation">Saiba Como</a>
            </div>
            <div class="img-container-presentation">
              <img src="../images/presentation-img.svg" alt="Apresentação">
            </div>
          </div>
        </div>

          <!--Benefícios-->
          <div class="align-div">
            <div class="benefits-wrapper">
              <div class="benefits-description-container">
                <h2 class="subtitle benefits">Quais benefícios planejamos entregar?</h2>
                <p class="description benefits">
                  Com o uso do sistema, podemos fazer o uso da tecnologia para mapear necessidades na cidade.
                </p>
              
                <p style="display: flex; align-items: center;" class="benefits-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp; Mapeamento de necessidades</p>
                <p style="display: flex; align-items: center;" class="benefits-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp;Transformar a ajuda em um processo dinâmico e simples</p>
                <p style="display: flex; align-items: center;" class="benefits-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp;Desenvolver o espírito de ajuda nas pessoas</p>
                <p style="display: flex; align-items: center;" class="benefits-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp;Melhorar a convivência da cidade</p>
              </div>
              <div class="img-container-benefits">
                <img src="../images/benefits-img.svg" alt="Benefícios">
              </div>
            </div>
          </div>

           <!--Comece por aqui-->
          <div class="start-wrapper">
            <div class="align-div">
              <div class="start-description-container">
                <h2 class="subtitle start">Comece Por Aqui</h2>
                <p style="margin-top: -20px" class="description start">
                  Não seja tímido, ajude ou nos deixe-te ajudar!
                </p>
              </div>
              <div class="start-cards-container">
                <div class="start-card">
                  <img class="point-img" src="../images/green-adress-point.png" alt="Card">
                  <div class="start-conditions">
                    <h3 class="point-title">Ponto de Doação</h3>
                    <p style="display: flex; align-items: center;" class="start-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp; Doe Necessidades</p>
                    <p style="display: flex; align-items: center;" class="start-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp; Ajude Pessoas</p>
                    <p style="display: flex; align-items: center;" class="start-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp; Buscamos em sua casa</p>
                    <p style="display: flex; align-items: center;" class="start-item-list"><img src="../images/checkmark.svg" alt="Checkmark">&nbsp;&nbsp; Combinamos o horário</p>
                  </div>
                  <form action="choose-point.php" method="POST">
                    <input type="hidden" name="tp_ponto" value="DO">
                    <button type="submit" class="start-card-button">Selecionar</button>
                  </form>
                </div>

                <div <?php echo $styleDisabled; ?> class="start-card">
                  <img class="point-img" src="../images/blue-adress-point.png" alt="Card">
                  <div class="start-conditions">
                    <h3 class="point-title">Ponto de Coleta</h3>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; Pontos de apoio para o recolhimento de doações</p>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; Entre em contato e leve sua doação até o ponto</p>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; O ponto será a casa de um administrador do sistema</p>
                  </div>
                  <form action="choose-point.php" method="POST">
                    <input type="hidden" name="tp_ponto" value="CO">
                    <button <?php echo $onlyAdmin; ?> type="<?php echo $btnActive; ?>" class="start-card-button">Selecionar</button>
                  </form>
                </div>

                <div <?php echo $styleDisabled; ?> class="start-card">
                  <img class="point-img" src="../images/yellow-adress-point.png" alt="Card">
                  <div class="start-conditions">
                    <h3 class="point-title">Ponto de Distribuição</h3>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; Eventos de distribuição de necessidades arrecadadas</p>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; Terão localização em pontos conhecidos na cidade</p>
                    <img src="../images/checkmark.svg" alt="Checkmark"><p style="display: flex; align-items: flex-start;" class="start-item-list">&nbsp;&nbsp; Todos que necessitarem de alguma ajuda podem comparecer</p>
                  </div>
                  <form action="choose-point.php" method="POST">
                    <input type="hidden" name="tp_ponto" value="DI">
                    <button <?php echo $onlyAdmin; ?> type="<?php echo $btnActive; ?>" class="start-card-button">Selecionar</button>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <div class="start-wrapper">
            <div class="align-div">
              <div class="start-description-container">
                <h2 class="subtitle start">Pontos abertos nesse momento</h2>
                <p style="margin-top: -20px" class="description start">
                  Acompanhe o nosso mapa e veja a solidariedade agir na sua cidade
                </p>
              </div>
              <br>
              <div id="mapid"></div>
            </div>
          </div>

          
          <div style="background: white!important;" class="start-wrapper">
            <div class="align-div">
              <div class="start-description-container">
                <h2 class="subtitle start">Relatos de Beneficiados</h2>
                <p style="margin-top: -20px" class="description start">
                  Essas pessoas foram impactadas pela solidáriedade por meio do programa SolidaryPoints, veja alguns deles.
                </p>
              </div>
            
              <div id="card-slider" class="splide">
                <div class="splide__track">
                  <ul class="splide__list">
                    <?php echo $cardFeedback; ?>
                  </ul>
                </div>
              </div>

            </div>
          </div>
          <div class="footer-basic">
            <footer>
                <div class="social"><a target="_blank" href="http://instagram.com/solidarypoints"><i class="icon ion-social-instagram"></i></a></div>
                <ul class="list-inline">
                    <li class="list-inline-item"><a href="index.php">Home</a></li>
                    <li class="list-inline-item"><a href="quem-somos.php">Sobre</a></li>
                    <li class="list-inline-item"><a href="feedback.php">Feedback</a></li>
                    <li class="list-inline-item"><a href="help.php">Ajuda</a></li>
                </ul>
                <p class="copyright">SolidaryPoints © 2021</p>
            </footer>
        </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
      </div>
    </div>

    <script>
      function onlyAdmin() {
        alert('Esse ponto só pode ser aberto por um administrador')
      }
    </script>
    <script>
      
      let perPageValue = 0;
      let screenWidth = screen.width;

      
      if(screenWidth > 1000) {
        document.addEventListener( 'DOMContentLoaded', function () {
            new Splide( '#card-slider', {
                perPage  : 3,
                //trimSpace: false,
                width: '90vw',
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

    <script>
        var map = L.map('mapid').setView([-4.129254, -38.239766], 13.5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        }).addTo(map);

        var blueIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',


          shadowSize:   [50, 64], // size of the shadow
          iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
          shadowAnchor: [4, 62],  // the same for the shadow
          popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
        var yellowIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-yellow.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',


            shadowSize:   [50, 64], // size of the shadow
            iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
            shadowAnchor: [4, 62],  // the same for the shadow
            popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
       });
       <?php echo $markers; ?>
        map.on('click', onMapClick);
    </script>
</body>
</html>