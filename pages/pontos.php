<?php
session_start();
if(isset($_SESSION['ID_USUARIO'])) {
  $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="login.html"><b>Entre</b></a></li> <li><a class="item-cadastro" href="cadastro.php">Cadastre-se</a></li>';
}


if($_SESSION["ADMIN"] == 'S') {
  $btnActive = "submit";
  $styleDisabled = "style='background: white;'";
}
else {
  $btnActive = "button";
  $styleDisabled = "style='background: #b7b7b7; opacity: .8'";
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
    <link rel="stylesheet" href="../styles/points.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
                      <a style="border-bottom: 1px solid #F53838;" href="pontos.php">Pontos</a>
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

      <div class="align-div">
        <div class="cards-description-container">
          <h2 style="margin-bottom: 0px!important;" class="title cards">Qual tipo de ponto você quer criar?</h2>
          <p class="description cards">
            Escolha o tipo de ponto que você quer criar no mapa da sua cidade
          </p>
        </div>
        <div class="card-points-page">
          <form action="choose-point.php" method="POST">
            <button type="submit" style="background: white;" class="card-points-card">
              <input type="hidden" name="tp_ponto" value="DO">
              <img src="../images/card.png" alt="">
              <p class="card-point-name">Ponto de Doação</p>
            </button>
          </form>
        
          <form action="choose-point.php" method="POST">
            <button type="<?php echo $btnActive; ?>" <?php echo $styleDisabled; ?> class="card-points-card">
              <input type="hidden" name="tp_ponto" value="CO">
              <img src="../images/card.png" alt="">
              <p class="card-point-name">Ponto de Coleta</p>
            </button>
          </form>
        
          <form action="choose-point.php" method="POST">
            <button type="<?php echo $btnActive; ?>" <?php echo $styleDisabled; ?> class="card-points-card">
              <input type="hidden" name="tp_ponto" value="DI">
              <img src="../images/card.png" alt="">
              <p class="card-point-name">Ponto de Distribuição</p>
            </button>
          </form>
        
          </div>
        </div>
      </div>

    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>