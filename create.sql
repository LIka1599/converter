CREATE DATABASE users;
use users;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(250) NOT NULL,
    pass VARCHAR(250) NOT NULL,
);
