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


    $cSqlA = "INSERT INTO USUARIOS (NOME,EMAIL,CONTATO,SENHA,CPF) VALUES('$nome','$email','$contato','$pass','$cpf') ";
    if (mysqli_query($conn, $cSqlA)) {
      $url = "../pages/created_account.php";
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
      $_SESSION['login'] = $login;
      $_SESSION['senha'] = $senha;
      while($row = mysqli_fetch_assoc($result)) {
        $_SESSION['ID_USUARIO'] = $row['ID'];
        $_SESSION['NOME'] = $row['NOME'];
      }
      $url = "pages/index.html";
      header('Location: '.$url.' ');
      exit();
    }else{
      unset ($_SESSION['login']);
      unset ($_SESSION['senha']);
      unset ($_SESSION['ID_USUARIO']);
      unset ($_SESSION['NOME']);

      $url = "pages/login.html?error='S'";
      header('Location: '.$url.' ');
      exit();
    }

  }
?>