<?php
  include 'config.php'; 
  $rua = $_POST["rua"];
  $bairro = $_POST["bairro"];
  $tipo_local = $_POST["tipo-local"];
  $numero = $_POST["numero"];
  $troco_para = $_POST["troco-para"];
  $produtos = $_POST["produtos"];
  $total_price = $_POST["total-price"];
  $data = date('Y-m-d H:i:s', time ());
  
  if (isset($bairro) && isset($rua) && isset($numero) && isset($produtos) && isset($produtos)  && isset($tipo_local)){
    $sql = "INSERT INTO pedidos (bairro, tipo_local, numero, produtos, troco_para, total, data) VALUES ('$bairro', '$tipo_local', '$numero', '$produtos', '$troco_para', '$total_price', '$data')";
    
    $cursor = $conn->query($sql);
    if ($conn->affected_rows==1){
      $sucesso = 1;
    }else {
      $sucesso = 0;
    }
  }
  
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio com Carrinho</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .cabecalho {
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #373839;
            color: aliceblue;
        }

        .carousel {
            display: flex;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 5px;
            scroll-behavior: smooth;
        }

        .carousel-item {
            flex: 0 0 200px;
            margin-right: 10px;
            background-color: white;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
        }

        .carousel-item div {
            padding: 5px;
        }

        .carousel-item h2 {
            margin-top: 0;
            font-size: 18px;
        }

        .carousel-item p {
            margin: 5px 0;
            font-size: 14px;
        }

        .item-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .change-button {
            padding: 8px 12px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .botao-mais {
            background-color: green;
        }

        .botao-menos {
            background-color: red;
        }

        .carrinho {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #373839;
            color: aliceblue;
            padding: 10px;
            box-shadow: 0px -2px 5px rgba(0, 0, 0, 0.2);
            display: none;
            align-items: center;
            justify-content: space-between;
        }

        .carrinho-img {
            height: 68px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .carrinho-info {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .carrinho-info p {
            margin: 5px 0;
            font-size: 18px;
        }

        .carrinho-botoes {
            display: flex;
            flex-direction: column;
            margin-right: 20px;
        }

        .botao-finalizar, .botao-cancelar {
            padding: 10px;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            margin-bottom: 10px;
        }

        .botao-finalizar {
            background-color: green;
        }

        .botao-cancelar {
            background-color: red;
        }



        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            margin: auto;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.6);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            overflow: auto;
            
        }

        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #form-entrega label,
        #form-entrega input,
        #form-entrega button {
            display: block;
            width: 90%;
            height: 30px;
            margin: auto;
            margin-bottom: 7px; /* Espaçamento entre os elementos do formulário */
        }

        #form-entrega label {
            margin-bottom: 5px; /* Espaçamento menor entre o label e o input correspondente */
        }

        @media screen and (max-width: 768px) {
            .modal-content {
                width: 80%;
            }
        }

        @media screen and (max-width: 480px) {
            .modal-content {
                width: 95%;
            }
        }

        .bt-finalisa-modal-cancela {
           background-color: #00FA9A;
           border: none;
           border-radius: 8px;
           color: black
        }

     



    </style>
</head>
<body>

    <div class="cabecalho">
        <h3>Cardápio</h3>
    </div>

    <div class="carousel">
        <?php
            // Inclui o arquivo de configuração da conexão com o banco de dados

            $query = "SELECT * FROM item"; // Consulta SQL para buscar produtos
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="carousel-item">';
                    echo '  <img src="img/' . $row['IMAGEM_PRODUTO'] . '" alt="' . $row['NOME_PRODUTO'] . '">';
                    echo '  <div>';
                    echo '   <h2>' . $row['NOME_PRODUTO'] . '</h2>';
                    echo '   <p>Preço: R$ ' . $row['PRECO'] . '</p>';
                    echo '  <div class="item-buttons">';
                    echo '    <button class="change-button botao-menos" data-price="' . $row['PRECO'] . '" data-id="' . $row['NOME_PRODUTO'] . '">-</button>';
                    echo '    <button class="change-button botao-mais" data-price="' . $row['PRECO'] . '" data-id="' . $row['NOME_PRODUTO'] . '">+</button>';
                    echo '</div></div></div>';
                }
            } else {
                echo 'Nenhum produto encontrado';
            }
            $conn->close();
            if ($sucesso == 1){
              // verifica se o pedido foi bem sucedido e executa o javascript abaixo.
        ?>
        
        <script>
        // script para dar um feedback sobre o Pedido.
          alert ("O seu pedido foi submetido com sucesso. Aguarde a entrega dos produtos.")
        </script>
        <?php
            }
        ?>
    </div>

    <div class="carrinho">
        <img src="img/compras-online.png" alt="Carrinho de Compras" class="carrinho-img">
        <div class="carrinho-info">
            <p>Valor Total: <span id="valor-total">R$ 0,00</span></p>
            <p>Total de itens: <span id="total-itens">0</span></p>
        </div>
        <div class="carrinho-botoes">
            <button class="botao-finalizar">Finalizar</button>
            <button class="botao-cancelar">Cancelar</button>
        </div>
    </div>

    <div id="modal-finalizar" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <h2>Informações para entrega</h2>
            <form id="form-entrega" action="" method="post">
                <label for="rua">Rua:</label> 
                <input type="text" id="rua" required="" name="rua"><br>
                <label for="bairro">Bairro:</label>
                <input required type="text" id="bairro" name="bairro"><br>
                <label for="tipo-local">Tipo local:</label>
                <input required type="text" id="tipo-local" name="tipo-local"><br>
                <label for="numero">Número:</label>
                <input required type="number" id="numero" name="numero"><br>
                <label for="troco-para">Troco para:</label>
                <input required type="text" id="troco-para" name="troco-para"><br>
                <input  type="hidden" name="produtos" id="produtos" value="" />
                <input type="hidden" name="total-price" id="totalidade" value="" />
                <button class="bt-finalisa-modal-cancela" type="submit" id="btn-localizacao">Finalizar Pedido</button>
                <button class="bt-finalisa-modal-cancela" type="button" id="btn-cancear">Cancelar</button>
            </form>
        </div>
    </div>

    <script>
        let = nome_do_produto = [];
        let carrinho = {};
        let carrao = document.querySelector(".carrinho");
        let cancelar = document.querySelector(".botao-cancelar");
        
        
        function contarProdutos(produtos) {
          // Objeto para armazenar a contagem de produtos
          const contagem = {};

          // Loop pelo array de produtos e contagem
          produtos.forEach(produto => {
          if (contagem[produto]) {
            contagem[produto]++;
          } else {
            contagem[produto] = 1;
          }
          });

          // Array para armazenar o resultado formatado
          const resultado = [];

          // Loop pelo objeto de contagem e formatar o resultado
          for (const produto in contagem) {
            resultado.push(`${contagem[produto]} - ${produto}`);
            }

          return resultado;
        }


        
        function updateTotal(id, price, isAdding) {
            let totalAtual = parseFloat(document.getElementById('valor-total').textContent.replace('R$ ', ''));
            let totalItens = parseInt(document.getElementById('total-itens').textContent);
            let totalidade = document.getElementById("totalidade");
            

            if (isAdding) {
                totalAtual += price;
                totalItens++;
                carrinho[id] = (carrinho[id] || 0) + 1;
                
                carrao.style.display = "flex";
            } else if (carrinho[id] && carrinho[id] > 0) {
                totalAtual -= price;
                totalItens--;
                carrinho[id]--;
                if (totalAtual == 0){
                  carrao.style.display = "none";
                }
            }

            document.getElementById('valor-total').textContent = `R$ ${totalAtual.toFixed(2)}`;
            document.getElementById('total-itens').textContent = totalItens;
            totalidade.value = document.getElementById('valor-total').textContent;
        }

        document.querySelectorAll('.botao-mais').forEach(button => {
            button.addEventListener('click', function(event) {
                let nome = event.target.parentNode.parentNode.firstChild.nextSibling.innerHTML;
                nome_do_produto.push (nome)
                let resultado = contarProdutos(nome_do_produto);
                
                document.getElementById("produtos").value = resultado;
                const id = this.getAttribute('data-id');
                const price = parseFloat(this.getAttribute('data-price'));
                updateTotal(id, price, true);
                
            });
        });

        document.querySelectorAll('.botao-menos').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const price = parseFloat(this.getAttribute('data-price'));
                updateTotal(id, price, false);
            });
        });

        cancelar.addEventListener("click", () => {
            carrao.style.display = "none";
            document.getElementById('valor-total').textContent = 0;
            document.getElementById('total-itens').textContent = 0;
            document.getElementById("produtos").value = null;
        });

        document.querySelector('.botao-finalizar').addEventListener('click', function() {
            document.getElementById('modal-finalizar').style.display = 'flex';
        });

        document.querySelector('.close-button').addEventListener('click', function() {
            document.getElementById('modal-finalizar').style.display = 'none';
            
        });
        
        document.querySelector('#btn-cancear').addEventListener('click', function() {

            document.getElementById('modal-finalizar').style.display = 'none';

        });

        /* document.getElementById('btn-localizacao').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    alert("Latitude: " + position.coords.latitude + "\nLongitude: " + position.coords.longitude);
                    // Preencher campos do formulário com as coordenadas ou utilizar como necessário
                });
            } else {
                alert("Geolocalização não é suportada neste navegador.");
            } 
        }); */

    </script>
</body>
</html>
