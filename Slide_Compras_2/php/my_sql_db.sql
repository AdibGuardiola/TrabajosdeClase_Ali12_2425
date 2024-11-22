DROP DATABASE IF EXISTS my_sql_db;  -- Cambia 'sql' por 'my_sql_db'
CREATE DATABASE my_sql_db;  -- Cambia 'sql' por 'my_sql_db'
USE my_sql_db;  -- Cambia 'sql' por 'my_sql_db'

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);
