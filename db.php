<?php
$servername = "localhost"; // endereço do servidor MySQL
$username = "root"; // nome de usuário do MySQL
$password = ""; // senha do MySQL
$dbname = "controle_financeiro"; // nome do banco de dados a ser utilizado

// cria uma nova conexão com o banco de dados usando a classe mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// verifica se ocorreu algum erro durante a conexão
if ($conn->connect_error) {
    // se houver erro, interrompe o script e exibe uma mensagem de erro
    die("Connection failed: " . $conn->connect_error);
}
?>
