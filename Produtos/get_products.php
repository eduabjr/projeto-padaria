<?php
include '../config/configuration.php';

$stmt = $pdo->query("SELECT id, nome FROM produtos");
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($produtos as $produto) {
    echo "<tr>
            <td>{$produto['id']}</td>
            <td>{$produto['nome']}</td>
            <td>
                <button class='editBtn' data-id='{$produto['id']}'>Editar</button>
                <button class='deleteBtn' data-id='{$produto['id']}'>Excluir</button>
            </td>
          </tr>";
}
