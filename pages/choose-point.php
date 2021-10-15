<?php 

echo $_POST["point"];

$conn = mysqli_connect("localhost","root","", "testes");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pontos | SolidaryPoints</title>
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
                      <a href="index.html">Home</a>
                  </li>
                  <li>
                      <a href="quem-somos.html">Sobre</a>
                  </li>
                  <li>
                      <a style="border-bottom: 1px solid #F53838; " href="pontos.html">Pontos</a>
                  </li>
                  <li>
                      <a href="nossos-servicos.html">Perfil</a>
                  </li>
                  
                  <li><a href="contato.php">Feedback</a></li>

                  <li><a href="contato.php">Ajuda</a></li>

                  <li><a style="display: flex;" href="../../../hda/helpdesk/pages/login.php">Mapa &nbsp;<img width="25px" src="../images/map-icon.svg"></a></li>
                  
                  <li><a href="contato.php"><b>Entre</b></a></li>

                  <li><a class="item-cadastro" href="contato.php">Cadastre-se</a></li>
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

      <div class="align-div">
        <div class="cards-description-container">
          <h2 style="display: flex; align-items: center; margin-bottom: 5px;" style="margin-bottom: 0px!important;" class="title cards">Ponto de Doação<img src="../images/yellow-adress-point.svg" alt="Marcação de ponto"></h2>
          <p style="padding: 5px;" class="description cards">
            Precisaremos de algumas informações para criar o seu ponto
          </p>
          <div class="question-point">
            <p class="ask-point">Qual tipo de doação você fará?</p>
            <!--CHECKBOXES-->
            <label class='container'>
              <input type='checkbox' id='1' class='checkbox' name='cDoacoes[]' value='1'><i></i>Roupas
              <span class='checkmark'>
            </label>
            <label class='container'>
              <input type='checkbox' id='1' class='checkbox' name='cDoacoes[]' value='1'><i></i>Comida
              <span class='checkmark'>
            </label>
            <label class='container'>
              <input type='checkbox' id='1' class='checkbox' name='cDoacoes[]' value='1'><i></i>Higiene
              <span class='checkmark'>
            </label>
          </div>
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

    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
  <script>
    var map = L.map('mapid').setView([-4.129254, -38.239766], 13.5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);

    function onMapClick(e) {
        alert("You clicked the map at " + e.latlng);
    }
    map.on('click', onMapClick);
</script>
</body>
</html>