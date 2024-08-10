<?php

if (isset ($_COOKIE["udydhdhzger"])){
        $n1 = $_GET["tokenAcess"];
        $n2 = $_COOKIE["udydhdhzger"];
        if ($n1 != $n2){
          header("Location: login.php");
          exit ();
        }
        
      }else {
        header("Location: login.php");
        exit ();
        
      }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Gerenciamento de Vendas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Painel de Gerenciamento de Vendas</h1>
        <nav>
          <button id="ins" onclick="nav ('pedidos.php')" class="late ativo">Pedidos Pendentes</button>
          <button onclick="nav ('validados.php')" id="cad" class="late">Pedidos Validados</button>
          <button onclick="nav ('')" id="cad" class="late">Pedidos Concluidos</button>
          
          
        </nav>
        <iframe src="pedidos.php" id="frm"  frameborder="0"></iframe>
    </div>
    
    
    
    <script>
      const frm = document.querySelector ("#frm");
      
      function nav (path){
        frm.src = path;
      }
      
      let botoes = [...document.querySelectorAll (".late")];
      
      botoes.map ((elemento)=>{
        elemento.addEventListener("click", (event)=>{
          botoes.map ((el)=>{
            el.classList.remove ('ativo');
          })
          event.target.classList.add ('ativo');
          
        })})
    </script>
</body>
</html>
