CREATE DATABASE IF NOT EXISTS ranking_db;
USE ranking_db;

CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    stars INT DEFAULT 0
);

-- Limpa a tabela para recarregar os dados fixos
TRUNCATE TABLE companies;

-- Insere os dados padrão (fixos)
INSERT INTO companies (name, stars) VALUES
    ('Brother''s 1', 0),
    ('Brother''s 2', 0),
    ('Chez Vous', 0),
    ('D''Cakes 1', 0),
    ('D''Cakes 2', 0),
    ('Divorari', 0),
    ('Dr. Pizza', 0),
    ('Flex Burguer', 0),
    ('Food Métricas', 0),
    ('Gorlami 1', 0),
    ('Gorlami 2', 0),
    ('Imperial Pizza', 0),
    ('Lupe Pizza', 0),
    ('Moo Very', 0),
    ('Pizza Nostra 1', 0),
    ('Pizza Nostra 2', 0),
    ('Pudinni 1', 0),
    ('Pudinni 2', 0),
    ('Seu Bibi Pastelaria 1', 0),
    ('Seu Bibi Pastelaria 2', 0),
    ('Torres Pizza', 0),
    ('Ulin Lanches', 0);
