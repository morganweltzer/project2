-- Drop the database if it exists and create a new one
DROP DATABASE IF EXISTS weltzeme;
CREATE DATABASE weltzeme;
USE weltzeme;

-- Drop existing tables if they exist
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS superusers;

-- Create users table
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    email VARCHAR(100),
    phone VARCHAR(20)
);

-- Create superusers table
CREATE TABLE superusers (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL
);

-- Insert data into users table
INSERT INTO users (username, password, firstname, lastname, email, phone) VALUES 
('Morgan', MD5('Password123!'), 'Morgan', 'Weltzer', 'weltzeme@mail.uc.edu', '1234567890');
