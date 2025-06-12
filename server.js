const express = require('express');
const mysql = require('mysql2');
const cors = require('cors');

const app = express();
const PORT = 3001;

// Middleware
app.use(cors());
app.use(express.json());

// Configuração da conexão com o banco de dados
const db = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root', // substitua com o seu usuário
    password: '', // substitua com sua senha
    database: 'entrega',
});

// Verifica a conexão
db.connect((err) => {
    if (err) {
        console.error('Erro ao conectar ao banco de dados:', err);
        return;
    }
    console.log('Conectado ao banco de dados MySQL.');
});

// Rota para criar um novo pedido
app.post('/pedidos', (req, res) => {
    const { nomeCliente, data_pedido, status } = req.body;
    
    if (!nomeCliente || !data_pedido || !status) {
        return res.status(400).json({ error: 'Todos os campos são obrigatórios.' });
    }

    const query = 'INSERT INTO informacoes_pedido (nomeCliente, data_pedido, status) VALUES (?, ?, ?)';
    db.query(query, [nomeCliente, data_pedido, status], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao criar pedido.' });
        }
        res.status(201).json({ id_pedido: results.insertId, nomeCliente, data_pedido, status });
    });
});

// Rota para buscar detalhes do pedido
app.get('/pedidos/:id', (req, res) => {
    const orderId = parseInt(req.params.id);
    if (isNaN(orderId)) {
        return res.status(400).json({ error: 'ID do pedido inválido.' });
    }

    db.query('SELECT * FROM informacoes_pedido WHERE id_pedido = ?', [orderId], (error, orderResults) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao buscar informações do pedido.' });
        }

        if (orderResults.length === 0) {
            return res.status(404).json({ error: 'Pedido não encontrado.' });
        }

        const order = orderResults[0];
        db.query('SELECT * FROM itens WHERE id_pedido = ?', [orderId], (error, itemResults) => {
            if (error) {
                return res.status(500).json({ error: 'Erro ao buscar itens do pedido.' });
            }
            res.json({ order, items: itemResults });
        });
    });
});

// Rota para atualizar um pedido
app.put('/pedidos/:id', (req, res) => {
    const orderId = parseInt(req.params.id);
    const { nomeCliente, data_pedido, status } = req.body;
    
    if (isNaN(orderId)) {
        return res.status(400).json({ error: 'ID do pedido inválido.' });
    }

    if (!nomeCliente || !data_pedido || !status) {
        return res.status(400).json({ error: 'Todos os campos são obrigatórios.' });
    }

    const query = 'UPDATE informacoes_pedido SET nomeCliente = ?, data_pedido = ?, status = ? WHERE id_pedido = ?';
    db.query(query, [nomeCliente, data_pedido, status, orderId], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao atualizar pedido.' });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ error: 'Pedido não encontrado.' });
        }
        res.json({ id_pedido: orderId, nomeCliente, data_pedido, status });
    });
});

// Rota para deletar um pedido
app.delete('/pedidos/:id', (req, res) => {
    const orderId = parseInt(req.params.id);
    if (isNaN(orderId)) {
        return res.status(400).json({ error: 'ID do pedido inválido.' });
    }

    db.query('DELETE FROM informacoes_pedido WHERE id_pedido = ?', [orderId], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao deletar pedido.' });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ error: 'Pedido não encontrado.' });
        }
        res.status(204).send(); // No Content
    });
});

// Rota para criar um novo item
app.post('/itens', (req, res) => {
    const { id_pedido, item, descrição, quantidade, preço } = req.body;

    if (!id_pedido || !item || !descrição || !quantidade || !preço) {
        return res.status(400).json({ error: 'Todos os campos são obrigatórios.' });
    }

    const query = 'INSERT INTO itens (id_pedido, item, descrição, quantidade, preço) VALUES (?, ?, ?, ?, ?)';
    db.query(query, [id_pedido, item, descrição, quantidade, preço], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao criar item.' });
        }
        res.status(201).json({ id_item: results.insertId, id_pedido, item, descrição, quantidade, preço });
    });
});

// Rota para atualizar um item
app.put('/itens/:id', (req, res) => {
    const itemId = parseInt(req.params.id);
    const { item, descrição, quantidade, preço } = req.body;

    if (isNaN(itemId)) {
        return res.status(400).json({ error: 'ID do item inválido.' });
    }

    if (!item || !descrição || !quantidade || !preço) {
        return res.status(400).json({ error: 'Todos os campos são obrigatórios.' });
    }

    const query = 'UPDATE itens SET item = ?, descrição = ?, quantidade = ?, preço = ? WHERE id_item = ?';
    db.query(query, [item, descrição, quantidade, preço, itemId], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao atualizar item.' });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ error: 'Item não encontrado.' });
        }
        res.json({ id_item: itemId, item, descrição, quantidade, preço });
    });
});

// Rota para deletar um item
app.delete('/itens/:id', (req, res) => {
    const itemId = parseInt(req.params.id);
    if (isNaN(itemId)) {
        return res.status(400).json({ error: 'ID do item inválido.' });
    }

    db.query('DELETE FROM itens WHERE id_item = ?', [itemId], (error, results) => {
        if (error) {
            return res.status(500).json({ error: 'Erro ao deletar item.' });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ error: 'Item não encontrado.' });
        }
        res.status(204).send(); // No Content
    });
});

// Inicia o servidor
app.listen(PORT, () => {
    console.log(`Servidor rodando em http://localhost:${PORT}`);
});
