-- create database
CREATE DATABASE IF NOT EXISTS bookstore;

-- use the database
USE bookstore;

-- create users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- create books table
CREATE TABLE IF NOT EXISTS books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL
);

-- insert sample book
INSERT INTO books (title, author, price, stock)
VALUES 
('The Pragmatic Programmer', 'Andrew Hunt', 29.99, 10),
('Clean Code', 'Robert C. Martin', 34.50, 5);