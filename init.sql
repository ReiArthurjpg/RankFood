CREATE DATABASE IF NOT EXISTS ranking_db;
USE ranking_db;

CREATE TABLE IF NOT EXISTS companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    stars INT DEFAULT 0
);

-- Insert default data if table is empty
INSERT INTO companies (name, stars)
SELECT * FROM (
    SELECT 'Brother''s Burguer' AS name, 15 AS stars UNION ALL
    SELECT 'Torres Pizza', 15 UNION ALL
    SELECT 'Ulin Lanches', 15 UNION ALL
    SELECT 'D''Cakes', 15 UNION ALL
    SELECT 'Divorari', 15 UNION ALL
    SELECT 'Seu Bibi Pastelaria', 15 UNION ALL
    SELECT 'Imperial Pizza', 15
) AS tmp
WHERE NOT EXISTS (
    SELECT name FROM companies
);
