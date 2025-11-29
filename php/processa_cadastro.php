<?php
// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "padaria1";

// Criar a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário e garantir que não estejam vazios
    $nome = isset($_POST['nome']) ? $_POST['nome'] : '';
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : '';
    $preco = isset($_POST['preco']) ? $_POST['preco'] : '';

    // Verificar se foi enviado um arquivo de imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === 0) {
        $imagem = $_FILES['imagem']['name'];
        $imagemTemp = $_FILES['imagem']['tmp_name'];
        $caminhoImagem = 'uploads/' . $imagem;

        // Mover a imagem para a pasta 'uploads'
        if (move_uploaded_file($imagemTemp, $caminhoImagem)) {
            // Usar prepared statements para evitar SQL injection
            $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $nome, $descricao, $preco, $caminhoImagem);

            if ($stmt->execute()) {
                echo "Produto cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o produto: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    } else {
        echo "Nenhuma imagem foi enviada.";
    }
}

$conn->close();
?>
