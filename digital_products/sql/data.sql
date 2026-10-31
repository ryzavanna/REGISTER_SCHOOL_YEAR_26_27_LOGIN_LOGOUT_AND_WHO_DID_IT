CREATE DATABASE IF NOT EXISTS digital_products_db;
USE digital_products_db;

-- 1. USER ENTITY TABLE
CREATE TABLE IF NOT EXISTS user_passwords (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 2. PARENT TABLE: designer
CREATE TABLE IF NOT EXISTS designer (
    designer_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    date_of_birth DATE,
    specialization TEXT,
    added_by VARCHAR(50) NOT NULL,
    last_updated_by VARCHAR(50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- 3. CHILD TABLE: digital_products
CREATE TABLE IF NOT EXISTS digital_products (
    digital_products_id INT AUTO_INCREMENT PRIMARY KEY,
    designer_id INT NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    product_type VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    sale_price DECIMAL(10, 2),
    added_by VARCHAR(50) NOT NULL,
    last_updated_by VARCHAR(50),
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    order_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_designer_digital_products 
        FOREIGN KEY (designer_id) 
        REFERENCES designer(designer_id) 
        ON DELETE CASCADE 
        ON UPDATE CASCADE
) ENGINE=InnoDB;