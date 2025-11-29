create database entrega;
use entrega;

create table informacoes_pedido (
id_pedido int primary key AUTO_INCREMENT,
nomeCliente varchar(50) not null,
data_pedido date not null,
status varchar(30) not null
);

create table itens (
id_item int primary key auto_increment,
id_pedido int,
item varchar(50) not null,
descrição varchar(50) not null,
quantidade int not null,
preço decimal(10, 2) not null,
FOREIGN KEY (id_pedido) REFERENCES informacoes_pedido(id_pedido) ON DELETE CASCADE
);

INSERT INTO informacoes_pedido (nomeCliente, data_pedido, status) VALUES 
('Maria Silva', '2024-10-01', 'Pendente'),
('João Santos', '2024-10-02', 'Concluído'),
('Ana Pereira', '2024-10-03', 'Cancelado'),
('Carlos Oliveira', '2024-10-04', 'Pendente'),
('Fernanda Costa', '2024-10-05', 'Concluído');

INSERT INTO itens (id_pedido, item, descrição, quantidade, preço) VALUES 
(1, 'Produto A', 'Descrição do Produto A', 2, 19.99),
(1, 'Produto B', 'Descrição do Produto B', 1, 29.99),
(2, 'Produto C', 'Descrição do Produto C', 3, 9.99),
(3, 'Produto D', 'Descrição do Produto D', 1, 15.49),
(4, 'Produto E', 'Descrição do Produto E', 5, 49.99);


select * from informacoes_pedido;