<?php 
// if((!isset ($_SESSION['login']) == true) and (!isset ($_SESSION['senha']) == true)){
// 	unset($_SESSION['login']);
// 	unset($_SESSION['senha']);
// 	header('location:'.PHPGRID_URL.'/login.php');
// } 

// $result = $conn->query($query);
 // while($row = $result->fetch_array()){
  
  // }
  $xScript = '';
  $conn = mysqli_connect("localhost","root","", "solidarypoints");

  //$query = "INSERT INTO USUARIOS (NOME) VALUES ('Felipe') ";
  // mysqli_query($conn, $query);
 

  if (!empty($_GET['visao'])){
    $xScript = $_GET["visao"];
  }
  if (!empty($_POST['visao'])){
    $xScript = $_POST["visao"];
  }

  if($xScript == 'cadastro') {
    $nome = $_POST["username"];
    $cpf = $_POST["cpf"];
    $contato = $_POST["contato"];
    $email = $_POST["email"];
    $pass = $_POST["pass"];
    $endereco = $_POST["endereco"];
    $numero = $_POST["numero"];
    $is_admin = $_POST["is_admin"];


    $cSqlA = "INSERT INTO USUARIOS (NOME,EMAIL,CONTATO,SENHA,CPF,ENDERECO,NUMERO,ADMIN) VALUES('$nome','$email','$contato','$pass','$cpf','$endereco','$numero','$is_admin') ";
    if (mysqli_query($conn, $cSqlA)) {
      $url = "pages/created-account.html";
      header('Location: '.$url.' ');
      exit();
    } else {
        echo "Error: " . $cSqlA . "<br>" . mysqli_error($conn);
    }
  }
  elseif($xScript == 'login') {
    // session_start inicia a sessão
    session_start();
    // as variáveis login e senha recebem os dados digitados na página anterior
    $login = $_POST['email'];
    $senha = $_POST['pass'];
	
    $sql77 = "SELECT * FROM USUARIOS WHERE REPLACE(EMAIL,'''','') = '".str_replace("'","",$login)."' AND replace(SENHA,'''','') = '".str_replace("'","",$senha)."'";

    $result = mysqli_query($conn, $sql77);


    if(mysqli_num_rows ($result) > 0 ){
      while($row = mysqli_fetch_assoc($result)) {
        if($row["ADMIN"] == 'S') {
          $_SESSION['ADMIN'] = 'S';
        }
        else {
          $_SESSION["ADMIN"] = 'N';
        }
        $_SESSION['ID_USUARIO'] = $row['ID'];
        $_SESSION['NOME'] = $row['NOME'];
      }
      echo $_SESSION["ADMIN"];
      $url = "pages/index.php";
      header('Location: '.$url.' ');
      exit();
    }
    else{
      unset ($_SESSION['login']);
      unset ($_SESSION['senha']);
      unset ($_SESSION['ID_USUARIO']);
      unset ($_SESSION['NOME']);

      $url = "pages/login.html?error='S'";
      header('Location: '.$url.' ');
      exit();
    }
  }
  elseif($xScript == 'open_point') { 
    session_start();
    $categorias = '';
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $tp_ponto = $_POST['tipo_ponto'];
    $dateAt = date('Ymd');
    $id_usuario = $_SESSION['ID_USUARIO'];
    $descricao = $_POST["desc"];
    $ref = $_POST['ref'];

    if(empty($_POST['cDoacoes'])) {
      $catArr = '';
    }
    else {
      $catArr = $_POST['cDoacoes'];
      foreach ($catArr as &$value) {
        $categorias .= $value.',';
      }
    }
    $categoriasF = substr($categorias,0,-1);
    
    
    $sql77 = "SELECT * FROM PONTOS WHERE USUARIO = $id_usuario AND STS = 'A'";

    $result = mysqli_query($conn, $sql77);
    //mysqli_num_rows ($result) < 1
    if(1==1){
      $query = "INSERT INTO PONTOS (DESCRICAO,LATLNG,CATEGORIAS,STS,TP_PONTO,USUARIO,DT,ENDERECO) VALUES('$descricao','$lat,$lng','$categoriasF','A','$tp_ponto','$id_usuario','$dateAt','$ref')";
      mysqli_query($conn, $query);

      $url = "pages/created-point.php";
      header('Location: '.$url.' ');
      exit();
    }
    
    else {
      $url = "pages/created-point.php?erro='S'";
      header('Location: '.$url.' ');
      exit();
    }
  }
  elseif($xScript == 'create_feedback') { 
    session_start();
    $feedbackMsg = $_POST['feedbackMsg'];
    $dateAt = date('Ymd');
    $id_usuario = $_SESSION['ID_USUARIO'];
    
    $query = "INSERT INTO FEEDBACK (MENSAGEM,USUARIO,STS,DT) VALUES('$feedbackMsg','$id_usuario','P','$dateAt')";
    mysqli_query($conn, $query);
    
    $url = "pages/created-feedback.php?tipo_msg=F";
    header('Location: '.$url.' ');
    exit();
  }
  elseif($xScript == 'create_help') { 
    session_start();
    $helpMsg = $_POST['helpMsg'];
    $dateAt = date('Ymd');
    $id_usuario = $_SESSION['ID_USUARIO'];
    
    $query = "INSERT INTO SUPORTE (MENSAGEM,USUARIO,STS,DT) VALUES('$helpMsg','$id_usuario','A','$dateAt')";
    mysqli_query($conn, $query);
    
    $url = "pages/created-feedback.php?tipo_msg=H";
    header('Location: '.$url.' ');
    exit();
}
elseif($xScript == 'aprovacao_feedback') { 
  $escolha = $_POST["tp_escolha"];
  $id_feedback = $_POST["id_feedback"];
  
  if($escolha == 'aprov') {
    $query = "UPDATE FEEDBACK SET STS = 'A' WHERE ID = ".$id_feedback."";
  }
  else {
    $query = "UPDATE FEEDBACK SET STS = 'C' WHERE ID = ".$id_feedback."";
  }
 
  mysqli_query($conn, $query);
  
  $url = "pages/aprov-feedbacks.php";
  header('Location: '.$url.' ');
  exit();
}
elseif($xScript == 'finaliza_suporte') { 
  $id_suporte = $_POST["id_suporte"];
  
  $query = "UPDATE SUPORTE SET STS = 'F' WHERE ID = ".$id_suporte."";
  mysqli_query($conn, $query);
  
  $url = "pages/suporte.php";
  header('Location: '.$url.' ');
  exit();
}
elseif($xScript == 'pontos_sts') { 
  $id_ponto = $_POST["id_ponto"];
  $tp_escolha = $_POST["tp_escolha"];
  
  $query = "UPDATE PONTOS SET STS = '".$tp_escolha."' WHERE ID = ".$id_ponto."";
  mysqli_query($conn, $query);
  
  $url = "pages/pontos-sts.php";
  header('Location: '.$url.' ');
  exit();
}
?>