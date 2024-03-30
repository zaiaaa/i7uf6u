CREATE DATABASE mydb;
USE mydb;

CREATE TABLE MyGuests (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(120),
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO MyGuests (firstname, lastname, email)
  VALUES ('John', 'Doe', 'john@example.com'),
   ('Kayky', 'turu', 'manu@example.com'),
   ('Matteus', 'urut', 'leo@example.com');