<?php 
$conn = mysqli_connect("localhost","root","", "solidarypoints");

function DataBr($data){
	if(!empty($data)) {
		return date("d/m/Y", strtotime($data));
	}
	else {
		return '-';
	}
}

session_start();
if(isset($_SESSION['ID_USUARIO'])) {
  $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="login.html"><b>Entre</b></a></li> <li><a class="item-cadastro" href="cadastro.php">Cadastre-se</a></li>';
}

if(isset($_SESSION["ADMIN"]) && $_SESSION["ADMIN"] == 'S') {
  $admin_perm = true;
}
else {
  $admin_perm = false;
}
if($admin_perm == false) {
  $xWhere = "AND P.TP_PONTO = 'DI'";
}
else {
  $xWhere = "";
}

$query = "
  SELECT P.ID,P.DESCRICAO,P.LATLNG,P.STS,P.TP_PONTO,P.CATEGORIAS,USR.NOME,P.ENDERECO, USR.NUMERO,DT FROM PONTOS P
  LEFT OUTER JOIN USUARIOS USR ON (USR.ID = P.USUARIO)
  WHERE P.STS = 'A'
  ".$xWhere."
";

$markers = '';
$result = $conn->query($query);
while($row = $result->fetch_array()){
  if($row["TP_PONTO"] == "DO") {
    $markers .= "
    L.marker([".$row['LATLNG']."], {icon: greenIcon}).addTo(map)
    .bindPopup(*<p class='title-card'>".$row['NOME']."</p><span class='adress'>- ".$row["ENDERECO"]."</span><a href='full-map.php?ver=S&myid=".$row['ID']."&tp_ponto=".$row['TP_PONTO']."'><button class='popup_btn'>Ver Ponto</button></a>*)
    ";
  }
  elseif($row["TP_PONTO"] == "DI") {
    $markers .= "
    L.marker([".$row['LATLNG']."], {icon: yellowIcon}).addTo(map)
    .bindPopup(*<p class='title-card'>".$row['DESCRICAO']."</p><span class='adress'>- ".$row["ENDERECO"]."</span><a href='full-map.php?ver=S&myid=".$row['ID']."&tp_ponto=".$row['TP_PONTO']."'><button class='popup_btn'>Ver Ponto</button></a>*)
    ";
  }
  elseif($row["TP_PONTO"] == "CO") {
    $markers .= "
    L.marker([".$row['LATLNG']."], {icon: blueIcon}).addTo(map)
    .bindPopup(*<p class='title-card'>".$row['DESCRICAO']."</p><span class='adress'>- ".$row["ENDERECO"]."</span><a href='full-map.php?ver=S&myid=".$row['ID']."&tp_ponto=".$row['TP_PONTO']."'><button class='popup_btn'>Ver Ponto</button></a>*)
    ";
  }
}

if(isset($_GET['ver']) == true){	
  $query = "
    SELECT P.ID,P.DESCRICAO,P.LATLNG,P.STS,P.TP_PONTO,P.CATEGORIAS,USR.NOME,P.ENDERECO, USR.NUMERO,DT FROM PONTOS P
    LEFT OUTER JOIN USUARIOS USR ON (USR.ID = P.USUARIO)
    WHERE P.ID = ".$_GET["myid"]."
    ";
    $result = $conn->query($query);
    while($row = $result->fetch_array()){
      $id = $row["ID"];
      $nome = $row["NOME"];
      $endereco = $row["ENDERECO"];
      $dt = $row["DT"];
      $descricao = $row["DESCRICAO"];
      $categorias = $row["CATEGORIAS"];
      $tp_ponto = $row["TP_PONTO"];
    }
  
  if($tp_ponto == 'DI') {
      $whiteScreen = '
        <div class="allContainer">
          <section class="detalhesDaLoja">
            <div class="detalhes-container">
            <img src="../images/close.svg" class="close" onclick="fechar()" />
              <div class="detalhesLoja">
                <header>
                  <h1>Ponto de Distribuição&nbsp;<img src="../images/yellow-adress-point.png"></h1>
                  <h2>ID#'.$id.'</h2>
                </header>
                <main>
                  <p>Descrição:  <strong>'.$descricao.'</strong></p>
                  <p>Endereço: <strong>'.$endereco.'</strong></p>
                  <p>Data: <strong>'.DataBr($dt).'</strong></</p>
                </main>
              </div>
            </div>
          </section>
        </div>
    ';
  }
  elseif($tp_ponto == 'CO') {
    $whiteScreen = '
      <div class="allContainer">
        <section class="detalhesDaLoja">
          <div class="detalhes-container">
          <img src="../images/close.svg" class="close" onclick="fechar()" />
            <div class="detalhesLoja">
              <header>
                <h1>Ponto de Coleta&nbsp;<img src="../images/blue-adress-point.png"></h1>
                <h2>ID#'.$id.'</h2>
              </header>
              <main>
                <p>Nome:  <strong>'.$nome.'</strong></p>
                <p>Endereço: <strong>'.$endereco.'</strong></p>
                <p>Data: <strong>'.DataBr($dt).'</strong></</p>
              </main>
            </div>
          </div>
        </section>
      </div>
  ';
}
elseif($tp_ponto == 'DO') {
  $whiteScreen = '
    <div class="allContainer">
      <section class="detalhesDaLoja">
        <div class="detalhes-container">
        <img src="../images/close.svg" class="close" onclick="fechar()" />
          <div class="detalhesLoja">
            <header>
              <h1>Ponto de Doação&nbsp;<img src="../images/green-adress-point.png"></h1>
              <h2>ID#'.$id.'</h2>
            </header>
            <main>
              <p>Nome:  <strong>'.$nome.'</strong></p>
              <p>Endereço: <strong>'.$endereco.'</strong></p>
              <p>Categorias:  <strong>'.$categorias.'</strong></p>
              <p>Data: <strong>'.DataBr($dt).'</strong></</p>
            </main>
          </div>
        </div>
      </section>
    </div>
';
}
	
	$bodyOverflow = '
		class="overflowHidden"
	';
}else {
	$whiteScreen = '';
	$bodyOverflow = '';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa | SolidaryPoints</title>
    <link rel="shortcut icon" href="../images/big-logo.png" />
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link rel="stylesheet" href="../styles/choose-point.css">
    <link rel="stylesheet" href="../styles/full-map.css">
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
<body <?php echo $bodyOverflow ?>>
<?php echo $whiteScreen ?>
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
        top: 0px;
    }
    #mapid {
      height: 90vh;
      z-index: 1;
      margin-top: 30px;
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
                      <a href="pontos.php">Pontos</a>
                  </li>
                  <li>
                      <a href="meu_perfil.php">Perfil</a>
                  </li>
                  
                  <li><a href="feedback.php">Feedback</a></li>

                  <li><a href="help.php">Ajuda</a></li>

                  <li><a style="display: flex; border-bottom: 1px solid #F53838;" href="full-map.php">Mapa &nbsp;<img width="25px" src="../images/map-icon.svg"></a></li>
                  
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
      <div id="mapid"></div>

    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
  <script>
    function fechar(){
				const allContainer = document.querySelector('.allContainer')
				const body = document.querySelector('body')
				allContainer.style.display = 'none'
				body.classList.toggle('overflowHidden')
			}
      
    var map = L.map('mapid').setView([-4.129254, -38.239766], 13.5);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    }).addTo(map);

    function onMapClick(e) {
      alert("You clicked the map at " + e.latlng.lat+e.latlng.lng);
      document.getElementById("lat").value = e.latlng.lat;
      document.getElementById("lng").value = e.latlng.lng;
    }

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

<?php echo str_replace('*','"',$markers);?>

</script>
</body>
</html>