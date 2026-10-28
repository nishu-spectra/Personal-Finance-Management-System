CREATE DATABASE IF NOT EXISTS personal_finance;
USE personal_finance;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(100)
);

CREATE TABLE income (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    source VARCHAR(100),
    amount DECIMAL(10,2),
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category VARCHAR(100),
    amount DECIMAL(10,2),
    date DATE,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    category VARCHAR(100),
    limit_amount DECIMAL(10,2),
    period ENUM('monthly', 'yearly'),
    FOREIGN KEY (user_id) REFERENCES users(id)
);