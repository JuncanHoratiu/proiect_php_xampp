CREATE DATABASE proiect_db;
USE proiect_db;

CREATE TABLE produse (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nume VARCHAR(100),
    pret FLOAT
);

INSERT INTO produse (nume, pret) VALUES
('Telefon Samsung', 2499.99),
('Laptop Dell', 3899.00),
('Paine integrala', 5.50),
('Tricou bumbac', 49.99),
('Minge fotbal', 89.00),
('Carte programare PHP', 75.00);


