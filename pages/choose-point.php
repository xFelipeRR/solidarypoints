<?php 
session_start();
if(isset($_SESSION['ID_USUARIO'])) {
  $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="contato.php"><b>Entre</b></a></li> <li><a class="item-cadastro" href="contato.php">Cadastre-se</a></li>';
}

$tp_ponto = $_POST["tp_ponto"];

if($tp_ponto == 'DO') {
  $pontoN = 'Doação';
  $pontoImg = '../images/green-adress-point.png';
  $descHidden = "hidden";
  $iconColor = "greenIcon";
}
elseif($tp_ponto == 'DI') {
  $pontoN = 'Distribuição';
  $pontoImg = '../images/yellow-adress-point.png';
  $descHidden = "required";
  $iconColor = "yellowIcon";
}
elseif($tp_ponto == 'CO') {
  $pontoN = 'Coleta';
  $pontoImg = '../images/blue-adress-point.png';
  $descHidden = "required";
  $iconColor = "blueIcon";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos | SolidaryPoints</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link rel="stylesheet" href="../styles/choose-point.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
     <!-- Make sure you put this AFTER Leaflet's CSS -->
     <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
     integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
     crossorigin=""></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
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
        margin: auto;
        position: relative;
        top: 100px;
    }
    .title {
      margin-top: -20px;
    }
    #mapid {
      height: 250px;
      z-index: 1;
    }
    .radios {
      display: flex;
      width: 40%;
      flex-wrap: wrap;
    }
    .radios label{
        display: table;
        margin-left: 30px;
        width: 100px;

        font-size: 15px;
    }

    .radios {
			display: flex;
			flex-direction: column;
      margin-left: 50px;
      flex: 1.8;
    }
      label {
          font-size: 27px;
      }
      .radio {
          margin-right: 50px;
      }
      /* The container */
      .container {
          /*display: block;*/
          position: relative;
          padding-left: 44px;
          cursor: pointer;
          font-size: 15px;
          -webkit-user-select: none;
          -moz-user-select: none;
          -ms-user-select: none;
          user-select: none;
      }

      /* Hide the browser's default radio button */
      .container input {
          position: absolute;
          opacity: 0;
          cursor: pointer;
      }

      /* Create a custom radio button */
      .checkmark {
          position: absolute;
          top: 0;
          left: 20px;
          height: 17px;
          width: 17px;
          background-color: #eee;
          border-radius: 50%;
      }

      /* On mouse-over, add a grey background color */
      .container:hover input ~ .checkmark {
          background-color: #ccc;
      }

      /* When the radio button is checked, add a blue background */
      .container input:checked ~ .checkmark {
          background-color: #d6231d;
      }

      /* Create the indicator (the dot/circle - hidden when not checked) */
      .checkmark:after {
          content: "";
          position: absolute;
          display: none;
      }

      /* Show the indicator (dot/circle) when checked */
      .container input:checked ~ .checkmark:after {
          display: block;
      }

      /* Style the indicator (dot/circle) */
      .container .checkmark:after {
          top: 5px;
          left: 4.2px;
          width: 8px;
          height: 8px;
          border-radius: 50%;
          background: white;
      }
      .point-info-wrapper {
        display: flex;
        flex-direction: column;
      }
      .point-info-container {
        margin: 5px;
      }
      .point-info {
        background: #fbfbfb;
        border: 1px solid #b3b3b3;
        border-radius: 5px;
        width: 100%;
        padding: 5px;
        outline: none;
      }
</style>

  <div id="wrapper">
    <div class="all-container">
      <div class="align-div">
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
      </div>
      <form action="../script.php" method="POST">
        <input type="hidden" id="visao" name="visao" value="open_point">  
        <input type="hidden" id="tipo_ponto" name="tipo_ponto" value="<?php echo $tp_ponto; ?>">  
        <input type="hidden" id="lat" name="lat" value="">  
        <input type="hidden" id="lng" name="lng" value="">
        <div class="align-div">
          <div class="cards-description-container">
            <h2 style="display: flex; align-items: center; margin-bottom: 5px;" style="margin-bottom: 0px!important;" class="title cards">Ponto de <?php echo $pontoN; ?><img src="<?php echo $pontoImg; ?>" alt="Marcação de ponto"></h2>
            <p style="padding: 5px;" class="description cards">
              Precisaremos de algumas informações para criar o seu ponto
            </p>
            <div class="point-info-wrapper">
              <div class="point-info-container">
                <label style="font-size: 20px;" for="desc" <?php echo $descHidden; ?>>Descrição do Ponto: </label>
                <input class="point-info" type="text" name="desc" id="desc" <?php echo $descHidden; ?>>
              </div>
              <div class="point-info-container">
                <label style="font-size: 20px;" for="ref">Referência do Ponto: </label>
                <input class="point-info" type="text" name="ref" id="ref">
              </div>
            </div>
            <?php if($tp_ponto == 'DO') { ?>
            <div class="question-point">
              <p class="ask-point">Qual o que o ponto oferecerá?</p>
              <!--CHECKBOXES-->
              <label class='container'>
                <input type='checkbox' id='1' class='checkbox' name='cDoacoes[]' value='R'><i></i>Roupas
                <span class='checkmark'>
              </label>
              <label class='container'>
                <input type='checkbox' id='2' class='checkbox' name='cDoacoes[]' value='C'><i></i>Comida
                <span class='checkmark'>
              </label>
              <label class='container'>
                <input type='checkbox' id='3' class='checkbox' name='cDoacoes[]' value='H'><i></i>Higiene
                <span class='checkmark'>
              </label>
            </div>
            <?php } ?>
          </div>
        </div>

        <div class="align-div">
          <div style="margin-top: 20px;" class="cards-description-container">
            <h2 style="font-size: 25px; display: flex; align-items: center; margin-bottom: 0px; margin-top: -10px;" style="margin-bottom: 0px!important;" class="title cards">Escolha o Local</h2>
            <p style="font-size: 15px; margin-bottom: 5px;" class="description cards">
              Clique em cima do local que você quer cadastrar o ponto
            </p>
            <div id="mapid"></div>
            <button class="insert-point-btn">Inserir</button>
          </div>
        </div>
    </form>

    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
  <script>
    var map = L.map('mapid').setView([-4.129254, -38.239766], 13.5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);

    var greenIcon = L.icon({
      iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
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
    var blueIcon = L.icon({
          iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
          shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',


          shadowSize:   [50, 64], // size of the shadow
          iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
          shadowAnchor: [4, 62],  // the same for the shadow
          popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });

    function onMapClick(e) {
      document.querySelector('#lat').value = e.latlng.lat;
      document.querySelector('#lng').value = e.latlng.lng;

      alert("Localização Escolhida!");
      //L.marker([latlng], {icon: <?php echo $iconColor; ?>}).addTo(map)
    }

    map.on('click', onMapClick);
</script>
</body>
</html>