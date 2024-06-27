<?php
include 'db.php';

// verifica se o método da requisição é POST (quando o formulário é submetido)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // obtém os dados do formulário enviado via POST
    $id_conta_pagar = $_POST['id_conta_pagar'];
    $id_empresa = $_POST['id_empresa'];
    $data_pagar = $_POST['data_pagar'];
    $valor = $_POST['valor'];

    // prepara o comando SQL para atualizar os dados na tabela tbl_conta_pagar
    $sql = "UPDATE tbl_conta_pagar SET id_empresa = $id_empresa, data_pagar = '$data_pagar', valor = $valor WHERE id_conta_pagar = $id_conta_pagar";

    // executa o comando SQL e verifica se foi executado com sucesso
    if ($conn->query($sql) === TRUE) {
        echo "Conta atualizada com sucesso"; // exibe mensagem de sucesso
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error; // exibe mensagem de erro se houver falha na execução do SQL
    }

    $conn->close(); // fecha a conexão com o banco de dados
    header("Location: index.php"); // redireciona o usuário de volta para a página inicial (index.php)
} else {
    // se o método da requisição não for POST, significa que é uma requisição GET para carregar o formulário de edição

    $id_conta_pagar = $_GET['id']; // obtém o ID da conta a pagar a ser editada via parâmetro GET
    $result = $conn->query("SELECT * FROM tbl_conta_pagar WHERE id_conta_pagar = $id_conta_pagar"); // consulta SQL para obter os dados da conta a pagar específica
    $row = $result->fetch_assoc(); // obtém os dados retornados pela consulta SQL
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Conta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="title">
        <h1>Editar Conta a Pagar</h1>
    </div>
    <div class="form-container">
        <form action="edit_conta.php" method="post"> <!-- Formulário para editar a conta -->
            <input type="hidden" name="id_conta_pagar" value="<?php echo $row['id_conta_pagar']; ?>"> <!-- campo oculto para enviar o ID da conta a pagar -->
            <label for="empresa">Empresa:</label>
            <select name="id_empresa" id="empresa">
                <?php
                // consulta SQL para obter todas as empresas da tabela tbl_empresa
                $result_empresas = $conn->query("SELECT id_empresa, nome FROM tbl_empresa");
                
                // loop para exibir as opções de seleção com as empresas encontradas
                while ($empresa = $result_empresas->fetch_assoc()) {
                    $selected = $empresa['id_empresa'] == $row['id_empresa'] ? 'selected' : ''; // verifica se a empresa atual é a mesma da conta a pagar sendo editada
                    echo "<option value='{$empresa['id_empresa']}' $selected>{$empresa['nome']}</option>"; // exibe a opção, marcando-a como selecionada se necessário
                }
                ?>
            </select><br>
            <label for="data_pagar">Data a pagar:</label>
            <input type="date" name="data_pagar" id="data_pagar" value="<?php echo $row['data_pagar']; ?>" required><br> <!-- campo para inserir a nova data a pagar -->
            <label for="valor">Valor:</label>
            <input type="number" step="0.01" name="valor" id="valor" value="<?php echo $row['valor']; ?>" required><br> <!-- campo para inserir o novo valor -->
            <button class="botaoSubmit" type="submit" value="Atualizar">Inserir</button> <!-- botão para enviar o formulário e atualizar a conta -->
        </form>
    </div>
</body>
</html>

<?php
}
?>
