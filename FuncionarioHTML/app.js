const express = require('express'); // Importa o módulo express para criar o servidor
const cors = require('cors'); // Importa o módulo CORS para permitir solicitações de diferentes origens
const mysql = require('mysql2'); // Importa o módulo MySQL para interagir com o banco de dados MySQL
const app = express(); // Cria uma instância do express para configurar o servidor

// Configuração de CORS para aceitar requisições de 'http://127.0.0.1' e 'http://localhost'
app.use(cors({
    origin: ['http://127.0.0.1', 'http://localhost']
}));

// Middleware para permitir o uso de JSON no corpo das requisições
app.use(express.json());

// Configuração opcional de Política de Segurança de Conteúdo (CSP)
app.use((req, res, next) => {
    res.setHeader("Content-Security-Policy", "default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline';");
    next();
});

// Configuração da conexão com o banco de dados MySQL
const db = mysql.createPool({
    host: '127.0.0.1',       // Endereço do host onde o banco de dados está localizado
    user: 'root',            // Nome de usuário do banco de dados
    password: '',            // Senha do banco de dados
    database: 's',           // Nome do banco de dados
    port: 3306               // Porta do banco de dados MySQL
});

// Verifica a conexão com o banco de dados ao iniciar o servidor
db.getConnection((err, connection) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err); // Mostra um erro caso a conexão falhe
        process.exit(1);                                           // Encerra o processo em caso de erro
    } else {
        console.log('Conexão com o banco de dados MySQL estabelecida.');
        connection.release();                                       // Libera a conexão após o teste

        // Inicia o servidor na porta 3001
        app.listen(3005, () => {
            console.log(`Servidor rodando em http://localhost:3005`);
        });
    }
});

// Rota inicial para confirmar que o servidor está ativo
app.get('/', (req, res) => {
    res.sendFile('C:/xampp/htdocs/projeto/index.html'); // Envia o arquivo HTML como resposta
});

// Criação de novo funcionário (CREATE)
app.post('/funcionarios', (req, res) => {
    const { nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado } = req.body; // Desestruturação para obter os dados do corpo da requisição

    // Query SQL para inserir um novo funcionário no banco de dados
    const sql = `INSERT INTO funcionarios (nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`;

    // Executa a query para inserir os dados
    db.query(sql, [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado], (err, result) => {
        if (err) {
            console.error("Erro ao inserir funcionário:", err);           // Mostra um erro caso ocorra ao inserir
            res.status(500).json({ error: "Erro ao inserir funcionário" }); // Retorna uma resposta de erro com status 500
            return;
        }
        res.status(201).json({ message: "Funcionário cadastrado com sucesso", id: result.insertId }); // Retorna uma resposta de sucesso com o ID do novo funcionário
    });
});

// Leitura de todos os funcionários (READ)
app.get('/funcionarios', (req, res) => {
    const sql = `SELECT * FROM funcionarios`; // Query SQL para selecionar todos os funcionários

    // Executa a query para buscar todos os funcionários
    db.query(sql, (err, results) => {
        if (err) {
            console.error("Erro ao buscar funcionários:", err);            // Mostra um erro caso ocorra ao buscar
            res.status(500).json({ error: "Erro ao buscar funcionários" }); // Retorna uma resposta de erro com status 500
            return;
        }
        res.json(results); // Retorna todos os funcionários em formato JSON
    });
});

// Leitura de um funcionário pelo código (READ)
app.get('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params; // Obtém o código do funcionário dos parâmetros da URL

    const sql = `SELECT * FROM funcionarios WHERE codigo = ?`; // Query SQL para selecionar um funcionário específico
    db.query(sql, [codigo], (err, results) => {
        if (err) {
            console.error("Erro ao buscar funcionário:", err);           // Mostra um erro caso ocorra ao buscar
            res.status(500).json({ error: "Erro ao buscar funcionário" }); // Retorna uma resposta de erro com status 500
            return;
        }
        if (results.length === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" }); // Retorna uma resposta 404 caso o funcionário não seja encontrado
        } else {
            res.json(results[0]); // Retorna o funcionário encontrado
        }
    });
});

// Atualização de um funcionário (UPDATE)
app.put('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params; // Obtém o código do funcionário dos parâmetros da URL
    const { nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado } = req.body; // Dados para atualização

    // Query SQL para atualizar o funcionário
    const sql = `UPDATE funcionarios SET nome = ?, sexo = ?, estadoCivil = ?, nacionalidade = ?, turno = ?, cargo = ?, rg = ?, cpf = ?, telefone = ?, email = ?, cep = ?, logradouro = ?, numero = ?, bairro = ?, cidade = ?, estado = ?
                 WHERE codigo = ?`;

    // Executa a query para atualizar os dados
    db.query(sql, [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado, codigo], (err, result) => {
        if (err) {
            console.error("Erro ao atualizar funcionário:", err);            // Mostra um erro caso ocorra ao atualizar
            res.status(500).json({ error: "Erro ao atualizar funcionário" }); // Retorna uma resposta de erro com status 500
            return;
        }
        if (result.affectedRows === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" }); // Retorna uma resposta 404 caso o funcionário não seja encontrado
        } else {
            res.json({ message: "Funcionário atualizado com sucesso" }); // Retorna uma mensagem de sucesso
        }
    });
});

// Exclusão de um funcionário (DELETE)
app.delete('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params; // Obtém o código do funcionário dos parâmetros da URL

    const sql = `DELETE FROM funcionarios WHERE codigo = ?`; // Query SQL para deletar um funcionário
    db.query(sql, [codigo], (err, result) => {
        if (err) {
            console.error("Erro ao excluir funcionário:", err);            // Mostra um erro caso ocorra ao excluir
            res.status(500).json({ error: "Erro ao excluir funcionário" }); // Retorna uma resposta de erro com status 500
            return;
        }
        if (result.affectedRows === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" }); // Retorna uma resposta 404 caso o funcionário não seja encontrado
        } else {
            res.json({ message: "Funcionário excluído com sucesso" }); // Retorna uma mensagem de sucesso
        }
    });
});

// Rota alternativa para redirecionamento
app.post('/cadastro', (req, res) => {
    res.redirect(307, '/funcionarios'); // Redireciona a requisição para a rota de criação de funcionário
});
