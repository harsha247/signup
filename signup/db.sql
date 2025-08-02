CREATE DATABASE IF NOT EXISTS signupdb;
USE signupdb;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  email VARCHAR(100),
  mobile VARCHAR(15),
  address TEXT,
  password VARCHAR(255)
);