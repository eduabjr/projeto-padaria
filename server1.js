const express = require('express');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const multer = require('multer');
const path = require('path');

// Configuração do servidor Express
const app = express();
const port = 3000;

// Middleware
app.use(bodyParser.json());
app.use(express.static('public'));  // Para servir arquivos estáticos (como imagens)

app.set('view engine', 'ejs');

// Configuração do banco de dados MySQL
const db = mysql.createConnection({
  host: '127.0.0.1',
  user: 'root',  // Substitua pelo seu usuário MySQL
  password: '',  // Substitua pela sua senha MySQL
  database: 's'  // Nome do banco de dados
});

db.connect((err) => {
  if (err) {
    console.error('Erro na conexão com o banco de dados:', err);
  } else {
    console.log('Conectado ao banco de dados MySQL');
  }
});

// Configuração do multer para upload de arquivos (como fotos)
const storage = multer.diskStorage({
  destination: (req, file, cb) => {
    cb(null, 'uploads/'); // O diretório para onde as fotos serão enviadas
  },
  filename: (req, file, cb) => {
    cb(null, Date.now() + path.extname(file.originalname)); // Nome único para o arquivo
  }
});

const upload = multer({ storage: storage });

// Rota para exibir o formulário de cadastro
app.get('/', (req, res) => {
  res.render('index'); // Renderiza o HTML de cadastro (arquivo EJS)
});

// Rota para cadastrar um funcionário
app.post('/cadastro', upload.single('foto'), (req, res) => {
  const { nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, endereco } = req.body;
  const foto = req.file ? req.file.path : null;

  const query = 'INSERT INTO funcionarios (nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, endereco) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  const values = [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, JSON.stringify(endereco)];

  db.query(query, values, (err, result) => {
    if (err) {
      console.error('Erro ao cadastrar funcionário:', err);
      res.status(500).send('Erro ao cadastrar funcionário');
    } else {
      res.redirect('/');
    }
  });
});

// Rota para listar todos os funcionários
app.get('/funcionarios', (req, res) => {
  db.query('SELECT * FROM funcionarios', (err, rows) => {
    if (err) {
      console.error('Erro ao buscar funcionários:', err);
      res.status(500).send('Erro ao buscar funcionários');
    } else {
      res.json(rows); // Retorna os dados dos funcionários em formato JSON
    }
  });
});

// Rota para editar um funcionário
app.post('/editar', upload.single('foto'), (req, res) => {
  const { id, nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, endereco } = req.body;
  const foto = req.file ? req.file.path : null;

  const query = `UPDATE funcionarios SET 
                    nome = ?, sexo = ?, estadoCivil = ?, nacionalidade = ?, turno = ?, cargo = ?, 
                    rg = ?, cpf = ?, telefone = ?, email = ?, endereco = ?, foto = ? 
                 WHERE id = ?`;
  const values = [nome, sexo, estadoCivil, nacionalidade, turno, cargo, rg, cpf, telefone, email, JSON.stringify(endereco), id];

  db.query(query, values, (err, result) => {
    if (err) {
      console.error('Erro ao editar funcionário:', err);
      res.status(500).send('Erro ao editar funcionário');
    } else {
      res.redirect('/');
    }
  });
});

// Rota para excluir um funcionário
app.post('/excluir', (req, res) => {
  const { id } = req.body;

  const query = 'DELETE FROM funcionarios WHERE id = ?';
  db.query(query, [id], (err, result) => {
    if (err) {
      console.error('Erro ao excluir funcionário:', err);
      res.status(500).send('Erro ao excluir funcionário');
    } else {
      res.redirect('/');
    }
  });
});

// Iniciar o servidor
app.listen(port, () => {
  console.log(`Servidor rodando em http://localhost:${port}`);
});
