<?php
session_start();
if(isset($_SESSION['ID_USUARIO'])) {
  $cHtml = "<li><a>Olá ".$_SESSION['NOME']."</a></li>";
}
else {
  $cHtml = '<li><a href="contato.php"><b>Entre</b></a></li> <li><a class="item-cadastro" href="contato.php">Cadastre-se</a></li>';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="../styles/general.css">
    <link rel="stylesheet" href="../styles/header.css">
    <script defer src="../js/header.js"></script>
    <link rel="stylesheet" href="../styles/meu_perfil.css">
    <title>Perfil | SolidaryPoints</title>
</head>
<body>
    <style>
        h2.title {
            margin-top: 15px;
            color: #dbdbdb!important;
        }
    </style>
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
                      <a style="border-bottom: 1px solid #F53838;" href="meu_perfil.php">Perfil</a>
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

    <header class="profile-cards">
        <section class="profile">
            <div class="profile-img">
                <img src="../images/user.jpg" alt="" class='profile_photo'>
            </div>
            <button class="edit" onclick='window.location.href = "informacoes.php"'>
                Editar
                <img src="../img/icons/edit.png" alt="">
            </button>
        </section>
        <section class="name">
            <h1 class="name">Felipe Rangel</h1>
            <p class="idUser">Usuário N° 12</p>
        </section>
        <section class="cards">
            <div class="card">
                <p class="card-title">Alimentos Doados</p>
                <h1 class="card-info">12</h1>
            </div>
            <div class="card">
                <p class="card-title">Números de participações</p>
                <h1 class="card-info">4</h1>
            </div>
        </section>
    </header>

    <div class="part-wrapper">
      <h2 style="font-size: 25px;" class="title">Participações</h2>
      <div class="part-container">
        <a href="#" class="part-card">
          <p class="part-p">Distribuição 1</p>
        </a>
        <a href="#" class="part-card">
          <p class="part-p">Distribuição 2</p>
        </a>
        <a href="#" class="part-card">
          <p class="part-p">Distribuição 3</p>
        </a>
      </div>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

</body>
</html>