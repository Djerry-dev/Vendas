

<?php
// Parâmetros de conexão
$host = 'localhost'; // ou IP do servidor de banco de dados
$username = 'root'; // seu usuário do MySQL
$password = '9421'; // sua senha do MySQL
$database = 'banco'; // nome do banco de dados

// Criando a conexão
$conn = new mysqli($host, $username, $password, $database);

// Verificando a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}



// Feche a conexão quando não for mais utilizada
// $conn->close();
?>





