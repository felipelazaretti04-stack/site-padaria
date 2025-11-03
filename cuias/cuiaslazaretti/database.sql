-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS cuiaslazaretti_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cuiaslazaretti_db;

-- Tabela usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'admin') DEFAULT 'cliente'
) ENGINE=InnoDB;

-- Tabela produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    categoria VARCHAR(100),
    estoque INT DEFAULT 0
) ENGINE=InnoDB;

-- Tabela pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    data TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total DECIMAL(10,2),
    status ENUM('pendente', 'enviado', 'entregue') DEFAULT 'pendente',
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela itens_pedido
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pedido INT,
    id_produto INT,
    quantidade INT,
    preco DECIMAL(10,2),
    FOREIGN KEY (id_pedido) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produto) REFERENCES produtos(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabela enderecos
CREATE TABLE enderecos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario INT,
    cep VARCHAR(10),
    cidade VARCHAR(100),
    estado VARCHAR(50),
    rua VARCHAR(255),
    numero VARCHAR(10),
    complemento VARCHAR(255),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Índices para otimização
CREATE INDEX idx_pedidos_usuario ON pedidos(id_usuario);
CREATE INDEX idx_itens_pedido ON itens_pedido(id_pedido);
CREATE INDEX idx_itens_produto ON itens_pedido(id_produto);
CREATE INDEX idx_enderecos_usuario ON enderecos(id_usuario);
