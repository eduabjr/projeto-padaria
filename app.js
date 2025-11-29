const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');

const app = express();

// Habilita o CORS e permite que o Express interprete JSON no corpo das requisições
app.use(cors());
app.use(express.json());

// Configura a Política de Segurança de Conteúdo (CSP)
app.use((req, res, next) => {
    res.setHeader("Content-Security-Policy", "default-src 'self'; img-src 'self' data:; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline';");
    next();
});

// Serve arquivos estáticos da pasta 'public'
app.use(express.static('public'));

// Configuração da conexão com o banco de dados MySQL
const db = mysql.createPool({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 's',
});

// Verifica a conexão com o banco ao iniciar o servidor
db.getConnection((err, connection) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        process.exit(1);
    } else {
        console.log('Conexão com o banco de dados MySQL estabelecida.');
        connection.release();
        
        // Inicia o servidor no localhost
        app.listen(3001, () => {
            console.log(`Servidor rodando em http://localhost:3001`);
        });
    }
});

// Rota inicial para confirmar que o servidor está ativo
app.get('/', (req, res) => {
    res.sendFile(__dirname + '/public/index.html');
});

// Criação de novo funcionário (CREATE)
app.post('/funcionarios', (req, res) => {
    const { nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado } = req.body;

    const sql = `INSERT INTO funcionarios (nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`;

    db.query(sql, [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado], (err, result) => {
        if (err) {
            console.error("Erro ao inserir funcionário:", err);
            res.status(500).json({ error: "Erro ao inserir funcionário" });
            return;
        }
        res.status(201).json({ message: "Funcionário cadastrado com sucesso", id: result.insertId });
    });
});

// Leitura de todos os funcionários (READ)
app.get('/funcionarios', (req, res) => {
    const sql = `SELECT * FROM funcionarios`;

    db.query(sql, (err, results) => {
        if (err) {
            console.error("Erro ao buscar funcionários:", err);
            res.status(500).json({ error: "Erro ao buscar funcionários" });
            return;
        }
        res.json(results);
    });
});

// Leitura de um funcionário pelo código (READ)
app.get('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params;

    const sql = `SELECT * FROM funcionarios WHERE codigo = ?`;
    db.query(sql, [codigo], (err, results) => {
        if (err) {
            console.error("Erro ao buscar funcionário:", err);
            res.status(500).json({ error: "Erro ao buscar funcionário" });
            return;
        }
        if (results.length === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" });
        } else {
            res.json(results[0]);
        }
    });
});

// Atualização de um funcionário (UPDATE)
app.put('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params;
    const { nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado } = req.body;

    const sql = `UPDATE funcionarios SET nome = ?, sexo = ?, estadoCivil = ?, nacionalidade = ?, turno = ?, cargo = ?, rg = ?, cpf = ?, telefone = ?, email = ?, cep = ?, logradouro = ?, numero = ?, bairro = ?, cidade = ?, estado = ?
                 WHERE codigo = ?`;

    db.query(sql, [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, cep, logradouro, numero, bairro, cidade, estado, codigo], (err, result) => {
        if (err) {
            console.error("Erro ao atualizar funcionário:", err);
            res.status(500).json({ error: "Erro ao atualizar funcionário" });
            return;
        }
        if (result.affectedRows === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" });
        } else {
            res.json({ message: "Funcionário atualizado com sucesso" });
        }
    });
});

// Exclusão de um funcionário (DELETE)
app.delete('/funcionarios/:codigo', (req, res) => {
    const { codigo } = req.params;

    const sql = `DELETE FROM funcionarios WHERE codigo = ?`;
    db.query(sql, [codigo], (err, result) => {
        if (err) {
            console.error("Erro ao excluir funcionário:", err);
            res.status(500).json({ error: "Erro ao excluir funcionário" });
            return;
        }
        if (result.affectedRows === 0) {
            res.status(404).json({ message: "Funcionário não encontrado" });
        } else {
            res.json({ message: "Funcionário excluído com sucesso" });
        }
    });
});

// Rota alternativa para redirecionamento
app.post('/cadastro', (req, res) => {
    res.redirect(307, '/funcionarios');
});
