<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            max-width: 500px;
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="file"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 15px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="text"]:focus, input[type="number"]:focus, input[type="file"]:focus {
            border-color: #0056b3;
        }

        select {
        width: 100%;
        padding: 8px;
        margin: 5px 0 15px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
        background-color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: 16px;
    }
    
    select:focus {
        border-color: #0056b3;
    }



        button {
            width: 100%;
            padding: 10px;
            background-color: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #003d7a;
        }
        h2 {
            color: #0056b3;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Cadastro de Produto</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nome">Nome do Produto:</label>
            <input type="text" id="nome" name="nome" required>
        </div>
        
        <div class="form-group">
            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" required>
        </div>

        <div class="form-group">
            <label for="imagem">Imagem do Produto:</label>
            <input type="file" id="imagem" name="imagem" accept="image/*" required>
        </div>

        <div class="form-group">
            <label for="preco">Preço:</label>
            <input type="Text" id="preco" name="preco" step="0.01" required>
        </div>
        
        <div class="form-group">
            <label for="tipo_item">Tipo do Item:</label>
            <select id="tipo_item" name="tipo_item" required>
                <option value="PIZZA">COMIDA</option>
                <option value="Bebida">BEBIDA</option>
            </select>
        </div>

        <div class="form-group">
            <label for="valor_custo">Valor de Custo:</label>
            <input type="Number" id="valor_custo" name="valor_custo"  oninput="formatarMoeda(this)" placeholder="R$ 0,00" required>
        </div>
        
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>
</div>

<?php
if (isset($_POST['cadastrar'])) {
    include 'config.php'; // Substitua 'conexao.php' pelo caminho do seu arquivo de conexão

    $nomeProduto = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $imagemProduto = $_FILES['imagem']['name'];
    $preco = $_POST['preco'];
    $tipoItem = $_POST['tipo_item'];
    $valorCusto = $_POST['valor_custo'];

    $diretorioUpload = 'uploads/';
    if (!is_dir($diretorioUpload)) {
        mkdir($diretorioUpload, 0777, true); // Cria o diretório se ele não existir
    }
    $caminhoCompleto = $diretorioUpload . basename($imagemProduto);

    if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
        echo "O arquivo " . htmlspecialchars(basename($imagemProduto)) . " foi carregado.";
    } else {
        echo "Ocorreu um erro ao fazer upload do arquivo.";
    }

    $sql = "INSERT INTO item (NOME_PRODUTO, DESCRICAO, IMAGEM_PRODUTO, PRECO, TIPO_ITEM, VALOR_DE_CUSTO) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdss", $nomeProduto, $descricao, $imagemProduto, $preco, $tipoItem, $valorCusto);

    if ($stmt->execute()) {
        echo "Novo registro criado com sucesso.";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>

</body>
</html>
