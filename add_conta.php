<?php
include 'db.php'; // inclui o arquivo de configuração do banco de dados

// recebe os dados do formulário via método POST
$id_empresa = $_POST['id_empresa'];
$data_pagar = $_POST['data_pagar'];
$valor = $_POST['valor'];

// prepara o comando SQL para inserir os dados na tabela tbl_conta_pagar
$sql = "INSERT INTO tbl_conta_pagar (id_empresa, data_pagar, valor) VALUES ('$id_empresa', '$data_pagar', '$valor')";

// executa o comando SQL e verifica se a inserção foi bem-sucedida
if ($conn->query($sql) === TRUE) {
    echo "Conta adicionada com sucesso"; // exibe mensagem de sucesso se a inserção for bem-sucedida
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error; // exibe mensagem de erro se houver falha na execução do SQL
}

$conn->close(); // fecha a conexão com o banco de dados
header("Location: index.php"); // redireciona o usuário de volta para a página inicial (index.php)
?>
