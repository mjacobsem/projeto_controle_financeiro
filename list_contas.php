<?php
include 'db.php';

// Construção da query base
$sql = "SELECT cp.id_conta_pagar, e.nome AS empresa, cp.valor, cp.data_pagar, cp.pago 
        FROM tbl_conta_pagar cp 
        JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa";

// Arrays para armazenar cláusulas WHERE e parâmetros
$where = [];
$params = [];

// Filtrar por empresa, se houver filtro
if (isset($_GET['filtro_empresa']) && $_GET['filtro_empresa'] !== '') {
    $where[] = "cp.id_empresa = ?";
    $params[] = $_GET['filtro_empresa'];
}

// Filtrar por valor, se houver filtro
if (isset($_GET['filtro_operador']) && isset($_GET['filtro_valor']) && $_GET['filtro_valor'] !== '') {
    $operador = $_GET['filtro_operador'];
    $valor = $_GET['filtro_valor'];
    
    switch ($operador) {
        case 'maior':
            $where[] = "cp.valor > ?";
            break;
        case 'menor':
            $where[] = "cp.valor < ?";
            break;
        case 'igual':
            $where[] = "cp.valor = ?";
            break;
        default:
            break;
    }
    
    $params[] = $valor;
}

// Filtrar por data, se houver filtro
if (isset($_GET['filtro_data']) && $_GET['filtro_data'] !== '') {
    $where[] = "cp.data_pagar = ?";
    $params[] = $_GET['filtro_data'];
}

// Se houver filtros, adicionar à query principal
if (!empty($where)) {
    $sql .= " WHERE " . implode(" AND ", $where);
}

// Preparar a query com os parâmetros
$stmt = $conn->prepare($sql);
if ($stmt) {
    // Bind dos parâmetros se houver
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // determina os tipos dos parâmetros
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Erro na preparação da consulta: " . $conn->error;
}

// Construir a tabela HTML com os resultados
echo "<table>
        <tr>
            <th>Empresa</th>
            <th>Valor</th>
            <th>Data a Pagar</th>
            <th>Pago</th>
            <th>Ações</th>
        </tr>";

while ($row = $result->fetch_assoc()) {
    // Formatar o valor para exibir como moeda brasileira (R$)
    $valor_formatado = number_format($row['valor'], 2, ',', '.');
    
    // Exibir cada linha da tabela com os dados da conta a pagar
    echo "<tr>
            <td>{$row['empresa']}</td>
            <td>R$ {$valor_formatado}</td>
            <td>{$row['data_pagar']}</td>
            <td>" . ($row['pago'] ? 'Sim' : 'Não') . "</td>
            <td>
                <a href='edit_conta.php?id={$row['id_conta_pagar']}'>Editar</a> | 
                <a href='delete_conta.php?id={$row['id_conta_pagar']}'>Excluir</a> | 
                <a href='pago.php?id={$row['id_conta_pagar']}'>Marcar como Paga</a>
            </td>
          </tr>";
}

echo "</table>";

// Fechar o statement e a conexão
$stmt->close();
$conn->close();
?>
