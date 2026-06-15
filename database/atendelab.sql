-- criando banco de dados
CREATE DATABASE IF NOT EXISTS atendelab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE atendelab;

-- criando as tabelas
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'aluno', 'atendente') DEFAULT 'atendente',
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pessoas ( 
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL, 
    documento VARCHAR(20) UNIQUE NOT NULL,
    telefone VARCHAR(12) UNIQUE, 
    curso VARCHAR(50),
    periodo VARCHAR(20),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
);


CREATE TABLE tipos_atendimentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_atendimento ENUM('agendado', 'cancelado', 'concluido', 'em_andamento', 'remarcado') DEFAULT 'agendado'
)

-- 3 foreign keys
CREATE TABLE atendimento (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    pessoa_id INT NOT NULL, 
    tipo_atendimento_id INT NOT NULL,
    data_hora_atendimento DATETIME,
    descricao TEXT,
    observacao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_pessoa FOREIGN KEY (pessoa_id) REFERENCES pessoas(id),
    CONSTRAINT fk_tipo_atendimento FOREIGN KEY (tipo_atendimento_id) REFERENCES tipos_atendimentos(id)
)


-- Inserindo um usuário inicial teste
INSERT INTO usuarios (nome, email, senha, perfil, status)
VALUES (
    'Administrador',
    'admin@atendelab.com',  
    '$2y$10$J9P2kU2BAMZ3TZcuxTsW4e1D/lka8EocYHzvyoOZmCNcWDQz3RuVC',
    'admin',
    'ativo'
);