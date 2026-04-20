CREATE DATABASE IF NOT EXISTS store_db;
USE store_db;

CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    description TEXT,
    image_filename VARCHAR(255) NOT NULL
);

INSERT INTO admin (username, password) VALUES ('admin', 'password123');

INSERT INTO product (name, price, quantity, description, image_filename) VALUES
('Laptop', 2499.99, 10, 'High performance laptop with 16GB RAM and 512GB SSD.', 'product1.jpg'),
('Smartphone', 1299.99, 25, 'Latest smartphone with 128GB storage and triple camera.', 'product2.jpg'),
('Headphones', 399.99, 30, 'Noise-cancelling wireless headphones with 30hr battery.', 'product3.jpg'),
('Keyboard', 199.99, 50, 'Mechanical gaming keyboard with RGB backlight.', 'product4.jpg');
