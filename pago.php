<?php
include 'db.php';

$id_conta_pagar = $_GET['id'];

// busca a conta e a data de pagamento
$sql = "SELECT valor, data_pagar FROM tbl_conta_pagar WHERE id_conta_pagar = $id_conta_pagar";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$valor = $row['valor'];
$data_pagar = $row['data_pagar'];
$data_atual = date('Y-m-d');

if ($data_atual < $data_pagar) {
    // desconto de 5%
    $valor_final = $valor * 0.95;
} elseif ($data_atual > $data_pagar) {
    // acréscimo de 10%
    $valor_final = $valor * 1.10;
} else {
    // sem desconto ou acréscimo
    $valor_final = $valor;
}

// atualiza a conta como paga e o valor final
$sql = "UPDATE tbl_conta_pagar SET pago = 1, valor = $valor_final WHERE id_conta_pagar = $id_conta_pagar";

if ($conn->query($sql) === TRUE) {
    echo "Conta marcada como paga com sucesso";
} else {
    echo "Erro: " . $sql . "<br>" . $conn->error;
}

$conn->close();
header("Location: index.php");
?>
