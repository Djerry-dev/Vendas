<?php
 include ('../config.php');
 
 $email = $_POST["email"];
 $senha = $_POST["senha"];
 
 if (isset ($_COOKIE["hshdyehe"])){
      $num = rand(1000, 9000);
    $ale = uniqid();
    $ales = uniqid();
    $token = $ales.$num.$ale;
    setcookie("udydhdhzger", $token);
    header("Location: index.php?tokenAcess=$token");
 }
 
 if (isset($senha) && isset($email)){
 $sql = "SELECT * FROM painel_admin WHERE username = '$email' AND password = '$senha'";
 $cursor = $conn->query($sql);
 
 if ($cursor->num_rows > 0) {
   echo "Sijvgggffffrr";
  $validad = strtotime("+1 day");
  setcookie("hshdyehe", "1", $validad, "/", "", false, true);
   $num = rand(1000, 9000);
    $ale = uniqid();
    $ales = uniqid();
    $token = $ales.$num.$ale;
    setcookie("udydhdhzger", $token);
    header("Location: index.php?tokenAcess=$token");
}
 }
 
 mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
      body {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        padding: 0;
        margin: 0;
        font-family: Arial;
      }
      
      h1 {
        text-align: center;
      }
    
      form {
        background: #316;
        border: 1px solid #aaa;
        border-radius: 10px;
        max-width: 600px;
        min-width: 300px;
        display: block;
        padding: 25px;
      }
      
      .campo {
        outline: none;
        height: 25px;
        display: block;
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 7px;
        border: 1px solid #aaa;
        margin-top: 5px;
        margin-bottom: 20px;
        width: 95%;
        background: #efefef;
      }
      
      label {
        margin-left: 7px;
      }
      
      #entrar {
        padding: 10px 20px;
        display: block;
        margin: auto;
        border-radius: 10px;
        border: none;
        background: #2ee;
        font-size: 16px;
        cursor: pointer;
        color: #006;
      }
      
    </style>
  </head>
  <body>
    
    <form action="" method="post">
      <h1>Faça Login</h1>
      
      <div>
      <label for="">Digite o seu E-mail</label>
      <input type="text" name="email" class="campo">
      </div>
      
      <div>
        <label for="">Password</label>
        <input type="password" name="senha" class="campo">
      </div>
      
      <input id="entrar" type="submit" value="Entrar">
    </form>
  </body>
</html>


