CREATE DATABASE users;
use users;

CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    login VARCHAR(250) NOT NULL,
    pass VARCHAR(250) NOT NULL
);

ALTER TABLE users ADD INDEX id (id);
ALTER TABLE users ADD INDEX login (login);
ALTER TABLE users ADD INDEX pass (pass);