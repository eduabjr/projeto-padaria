const express = require('express');
const mysql = require('mysql2');
const cors = require('cors'); 

const app = express();
const port = 3000;

app.use(express.json());
app.use(cors()); 

const db = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'fornecedores_db',
});

db.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        return;
    }
    console.log('Conectado ao banco de dados MySQL!');
});

app.post('/suppliers', (req, res) => {
    const { supplierID, supplierName, phone, email, address } = req.body;

    // Garantir que supplierID seja tratado como string
    const query = `INSERT INTO suppliers (supplierID, supplierName, phone, email, address) 
                   VALUES (?, ?, ?, ?, ?)`; 

    db.query(query, [supplierID.toString(), supplierName, phone, email, address], (err, result) => {
        if (err) {
            console.error('Erro ao cadastrar fornecedor:', err);
            return res.status(500).json({ message: 'Erro ao cadastrar fornecedor.' });
        }
        res.status(200).json({ message: 'Fornecedor cadastrado com sucesso!' });
    });
});

app.put('/suppliers/:supplierID', (req, res) => {
    const { supplierID } = req.params;
    const { supplierName, phone, email, address } = req.body;

    // Garantir que supplierID seja tratado como string
    const query = `UPDATE suppliers SET supplierName = ?, phone = ?, email = ?, address = ? 
                   WHERE supplierID = ?`;

    db.query(query, [supplierName, phone, email, address, supplierID.toString()], (err, result) => {
        if (err) {
            console.error('Erro ao atualizar fornecedor:', err);
            return res.status(500).json({ message: 'Erro ao atualizar fornecedor.' });
        }

        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Fornecedor não encontrado.' });
        }

        res.status(200).json({ message: 'Fornecedor alterado com sucesso!' });
    });
});

//Pega todos o fornecedores
app.get('/suppliers', (req, res) => {
    const query = 'SELECT * FROM suppliers';
    db.query(query, (err, results) => {
        if (err) {
            console.error('Erro ao buscar fornecedores:', err);
            return res.status(500).json({ message: 'Erro ao buscar fornecedores.' });
        }
        res.status(200).json(results);
    });
});

//Pega um fornecedor por ID
app.get('/suppliers/:id', (req, res) => {
    const { id } = req.params;
    const query = 'SELECT * FROM suppliers WHERE supplierID = ?';
    db.query(query, [id], (err, results) => {
        if (err) {
            console.error('Erro ao obter fornecedor:', err);
            return res.status(500).json({ message: 'Erro ao obter fornecedor.' });
        }
        if (results.length === 0) {
            return res.status(404).json({ message: 'Fornecedor não encontrado.' });
        }
        res.status(200).json(results[0]);
    });
});

//Atualizar um fornecedor
app.put('/suppliers/:supplierID', (req, res) => {
    const { supplierID } = req.params;
    const { supplierName, phone, email, address } = req.body;

    const query = `UPDATE suppliers SET supplierName = ?, phone = ?, email = ?, address = ? 
                   WHERE supplierID = ?`;

    db.query(query, [supplierName, phone, email, address, supplierID], (err, result) => {
        if (err) {
            console.error('Erro ao atualizar fornecedor:', err);
            return res.status(500).json({ message: 'Erro ao atualizar fornecedor.' });
        }

        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Fornecedor não encontrado.' });
        }

        res.status(200).json({ message: 'Fornecedor alterado com sucesso!' });
    });
});

//Deletar um fornecedor
app.delete('/suppliers/:supplierID', (req, res) => {
    const { supplierID } = req.params;

    const query = `DELETE FROM suppliers WHERE supplierID = ?`;
    
    db.query(query, [supplierID], (err, result) => {
        if (err) {
            console.error('Erro ao excluir fornecedor:', err);
            return res.status(500).json({ message: 'Erro ao excluir fornecedor.' });
        }

        if (result.affectedRows === 0) {
            return res.status(404).json({ message: 'Fornecedor não encontrado.' });
        }

        res.status(200).json({ message: 'Fornecedor excluído com sucesso!' });
    });
});


app.listen(port, () => {
    console.log(`Servidor rodando em http://localhost:${port}`);
});
