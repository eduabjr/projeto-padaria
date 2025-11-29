<?php
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $telefone = $_POST['phone'];
    $endereco = $_POST['address'];
    $nacionalidade = $_POST['nationality'];
    $bairro = $_POST['neighborhood'];
    $cidade = $_POST['city'];
    $estado = $_POST['state'];
    $tipo_cliente = $_POST['clientType'];
    $sexo = isset($_POST['sexo']) ? $_POST['sexo'] : null;
    $cpf = isset($_POST['cpf']) ? $_POST['cpf'] : null;
    $rg = isset($_POST['rg']) ? $_POST['rg'] : null;
    $cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : null;

    // Consulta para atualizar os dados
    if ($tipo_cliente == 'individual') {
        $sql = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco', 
                nacionalidade='$nacionalidade', bairro='$bairro', cidade='$cidade', estado='$estado', 
                tipo_cliente='$tipo_cliente', sexo='$sexo', cpf='$cpf', rg='$rg', cnpj=NULL WHERE id=$id";
    } else {
        $sql = "UPDATE clientes SET nome='$nome', email='$email', telefone='$telefone', endereco='$endereco', 
                nacionalidade='$nacionalidade', bairro='$bairro', cidade='$cidade', estado='$estado', 
                tipo_cliente='$tipo_cliente', sexo=NULL, cpf=NULL, rg=NULL, cnpj='$cnpj' WHERE id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header('Location: cadastro_cliente.php');
        exit();
    } else {
        echo "Erro ao atualizar os dados: " . mysqli_error($conn);
    }
}
