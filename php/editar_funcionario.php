<?php
include '../config/config2.php';

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Recebe o ID do funcionário para editar

    // Consulta para obter os dados do funcionário
    $sql = "SELECT * FROM funcionarios WHERE codigo = $id";
    $result = mysqli_query($conn, $sql);
    $funcionario = mysqli_fetch_assoc($result);

    if (!$funcionario) {
        echo "Funcionário não encontrado.";
        exit;
    }

    // Aqui você pode criar um formulário HTML com os dados do funcionário
    ?>

    <form method="POST" action="atualizar_funcionario.php">
        <input type="hidden" name="id" value="<?= $funcionario['codigo'] ?>">

        <label for="nome">Nome</label>
        <input type="text" name="nome" value="<?= $funcionario['nome'] ?>" required>

        <label for="sexo">Sexo</label>
        <select name="sexo" required>
            <option value="Masculino" <?= $funcionario['sexo'] == 'Masculino' ? 'selected' : '' ?>>Masculino</option>
            <option value="Feminino" <?= $funcionario['sexo'] == 'Feminino' ? 'selected' : '' ?>>Feminino</option>
        </select>

        <label for="email">Email</label>
        <input type="email" name="email" value="<?= $funcionario['email'] ?>" required>

        <!-- Coloque outros campos conforme necessário -->

        <button type="submit">Salvar</button>
    </form>

    <?php
    mysqli_close($conn);
} else {
    echo "ID do funcionário não fornecido.";
}
?>
