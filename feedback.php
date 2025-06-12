<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - Padaria Clementino</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fdf5e6;
            margin: 0;
            padding: 0;
        }
        .form-container, .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #b22222;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .star-rating {
            direction: rtl;
            display: inline-block;
            font-size: 0;
            white-space: nowrap;
            position: relative;
            height: 40px;
            line-height: 40px;
        }
        .star-rating input {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }
        .star-rating label {
            font-size: 30px;
            color: #ddd;
            cursor: pointer;
            display: inline-block;
        }
        .star-rating label:before {
            content: '★';
        }
        .star-rating input:checked ~ label {
            color: #b22222;
        }
        .star-rating input:checked ~ label ~ label {
            color: #b22222;
        }
        .submit-btn {
            background-color: #b22222;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .submit-btn:hover {
            background-color: #a11d1d;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #b22222;
            color: #fff;
        }
        .btn {
            padding: 5px 10px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-delete {
            background-color: #b22222;
        }
        .btn-update {
            background-color: #ffa500;
        }
        .btn-back {
            background-color: #4CAF50;
            padding: 10px;
            text-align: center;
            width: 100%;
            border: none;
            border-radius: 5px;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-back:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h1>Envie seu Feedback</h1>
        <?php
        if (isset($_GET['success']) && $_GET['success'] == 1) {
            echo "<p style='text-align: center; color: #4CAF50;'>Feedback enviado com sucesso!</p>";
            echo "<form action='feedback.php' method='get'>
                    <input type='submit' value='Voltar para os Feedbacks' class='btn-back'>
                  </form>";
        } else {
            ?>
            <form action="process_feedback.php" method="post">

                <div>
                    <label for="name">Nome:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="feedback">Seu Feedback:</label>
                    <textarea id="feedback" name="feedback" rows="6" required></textarea>
                </div>
                <p>Classifique nosso serviço:</p>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5">
                    <label for="star5"></label>
                    <input type="radio" id="star4" name="rating" value="4">
                    <label for="star4"></label>
                    <input type="radio" id="star3" name="rating" value="3">
                    <label for="star3"></label>
                    <input type="radio" id="star2" name="rating" value="2">
                    <label for="star2"></label>
                    <input type="radio" id="star1" name="rating" value="1">
                    <label for="star1"></label>
                </div>

                <input type="submit" value="Enviar Feedback" class="submit-btn">
            </form>
            <?php
        }
        ?>
    </div>

    <!-- Conexão com o banco de dados e exibição da tabela -->
    <div class="container">
        <h1>Feedbacks Recebidos</h1>
        <?php
        // Conexão com o banco de dados
        $servername = "127.0.0.1";
        $username = "root";
        $password = "";
        $dbname = "feedback";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Falha na conexão: " . $conn->connect_error);
        }

        // Consulta para buscar os feedbacks
        $sql = "SELECT * FROM feedback";
        $result = $conn->query($sql);

        echo "<table>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Feedback</th>
                    <th>Avaliação</th>
                    <th>Ações</th>
                </tr>";
        
        // Exibe cada linha de feedback
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td>" . $row["name"] . "</td>
                        <td>" . $row["email"] . "</td>
                        <td>" . $row["feedback"] . "</td>
                        <td>" . $row["rating"] . "</td>
                        <td>
                            <a href='update_feedback.php?id=" . $row["id"] . "' class='btn btn-update'>Atualizar</a>
                            <a href='delete_feedback.php?id=" . $row["id"] . "' class='btn btn-delete' onclick=\"return confirm('Tem certeza que deseja deletar este feedback?');\">Deletar</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Nenhum feedback encontrado.</td></tr>";
        }
        echo "</table>";

        $conn->close();
        ?>
    </div>

</body>
</html>
