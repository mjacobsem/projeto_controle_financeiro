<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Controle Financeiro</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="title">
        <h1>Controle Financeiro de Contas a Pagar</h1>
    </div>

    <!-- Formulário para adicionar uma nova conta a pagar -->
    <div class="form-container">
        <form action="add_conta.php" method="post">
            <label for="empresa">Empresa:</label>
            <select name="id_empresa" id="empresa">
                <?php
                // inclui o arquivo de configuração do banco de dados
                include 'db.php';

                // executa uma consulta SQL para buscar todas as empresas da tabela tbl_empresa
                $result = $conn->query("SELECT id_empresa, nome FROM tbl_empresa");

                // loop para exibir opções de seleção com as empresas encontradas
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='{$row['id_empresa']}'>{$row['nome']}</option>";
                }
                ?>
            </select><br>

            <label for="data_pagar">Data a pagar:</label>
            <input type="date" name="data_pagar" id="data_pagar" required><br>

            <label for="valor">Valor:</label>
            <input type="number" step="0.01" name="valor" id="valor" required><br>

            <button class="botaoSubmit" type="submit" value="Inserir">Inserir</button> <!-- botão para enviar o formulário -->
        </form>
    </div>

    <div class="form-container2">
    <form action="index.php" method="get">
        <!-- dropdown para filtrar por empresa -->
        <label for="filtro_empresa">Filtrar por Empresa:</label>
        <select name="filtro_empresa" id="filtro_empresa">
            <option value="">Todas</option>
            <?php
            // consulta para obter todas as empresas cadastradas
            $result_empresas = $conn->query("SELECT id_empresa, nome FROM tbl_empresa");
            while ($empresa = $result_empresas->fetch_assoc()) {
                // define a opção como selecionada se corresponder ao filtro aplicado
                $selected = isset($_GET['filtro_empresa']) && $_GET['filtro_empresa'] == $empresa['id_empresa'] ? 'selected' : '';
                echo "<option value='{$empresa['id_empresa']}' $selected>{$empresa['nome']}</option>";
            }
            ?>
        </select>

        <!-- dropdown e input para filtrar por valor -->
        <label for="filtro_valor">Filtrar por Valor:</label>
        <select class="filtrovalor" name="filtro_operador" id="filtro_operador">
            <option value="maior" <?php echo isset($_GET['filtro_operador']) && $_GET['filtro_operador'] == 'maior' ? 'selected' : ''; ?>>Maior que</option>
            <option value="menor" <?php echo isset($_GET['filtro_operador']) && $_GET['filtro_operador'] == 'menor' ? 'selected' : ''; ?>>Menor que</option>
            <option value="igual" <?php echo isset($_GET['filtro_operador']) && $_GET['filtro_operador'] == 'igual' ? 'selected' : ''; ?>>Igual a</option>
        </select>
        <input class="filtrovalor" type="number" name="filtro_valor" id="filtro_valor" step="0.01" value="<?php echo isset($_GET['filtro_valor']) ? $_GET['filtro_valor'] : ''; ?>">

        <!-- input para filtrar por data -->
        <label for="filtro_data">Filtrar por Data:</label>
        <input class="filtrodata" type="date" name="filtro_data" id="filtro_data" value="<?php echo isset($_GET['filtro_data']) ? $_GET['filtro_data'] : ''; ?>">

        <!-- botão de submit para enviar o formulário de filtro -->
        <button class="botaoSubmit" type="submit" value="Filtrar">Filtrar</button>
    </form>
</div>

    <!-- inclui o script PHP que lista todas as contas a pagar -->
    <?php include 'list_contas.php'; ?>

</body>
</html>
