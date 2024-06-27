<?php
include 'db.php'; // inclui o arquivo de configuração do banco de dados

$id_conta_pagar = $_GET['id']; // obtém o ID da conta a pagar a ser excluída via parâmetro GET

$sql = "DELETE FROM tbl_conta_pagar WHERE id_conta_pagar = $id_conta_pagar"; // comando SQL para excluir a conta a pagar

if ($conn->query($sql) === TRUE) {
    echo "Conta excluída com sucesso"; // exibe mensagem de sucesso se a exclusão for bem-sucedida
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error; // exibe mensagem de erro se houver falha na execução do SQL
}

$conn->close(); // fecha a conexão com o banco de dados
header("Location: index.php"); // redireciona o usuário de volta para a página inicial (index.php)
?>
