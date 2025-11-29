<?php
include('config/conexao.php'); // Inclui o arquivo de conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];
    $sexo = $_POST['sexo'];
    $estado_civil = $_POST['estado_civil'];
    $nacionalidade = $_POST['nacionalidade'];
    $turno = $_POST['turno'];
    $cargo = $_POST['cargo'];
    $rg = $_POST['rg'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];
    $cep = $_POST['cep'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $bairro = $_POST['bairro'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO funcionarios (codigo, nome, sexo, estado_civil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado) 
            VALUES (:codigo, :nome, :sexo, :estado_civil, :nacionalidade, :turno, :cargo, :rg, :cpf, :telefone, :email, :cep, :logradouro, :numero, :bairro, :cidade, :estado)";
    
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':sexo', $sexo);
    $stmt->bindParam(':estado_civil', $estado_civil);
    $stmt->bindParam(':nacionalidade', $nacionalidade);
    $stmt->bindParam(':turno', $turno);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':cpf', $cpf);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':numero', $numero);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':estado', $estado);
    
    if ($stmt->execute()) {
        echo "Funcionário cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar funcionário.";
    }
}
?>
