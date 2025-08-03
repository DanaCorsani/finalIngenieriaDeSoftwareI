CREATE DATABASE ambd;
USE ambd;

CREATE TABLE roles(
	rol_id INT PRIMARY KEY,
    rol_desc VARCHAR(30)
);

CREATE TABLE usuarios(
	usu_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30),
    apellido VARCHAR(30),
    clave VARCHAR(255),
    dni VARCHAR(15),
    sucursal VARCHAR(30),
    email VARCHAR(100),
    fechaIngreso DATE,
    rol_id INT,
    FOREIGN KEY (rol_id) REFERENCES roles(rol_id)
);

CREATE TABLE cursos(
	cur_id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(30),
    area ENUM('cocina','atencion','limpieza'),
    estado ENUM('activo','inactivo'),
    pdf VARCHAR(255),
    cur_desc VARCHAR(255),
    video VARCHAR(255),
    preg_1 VARCHAR(255),
    preg_2 VARCHAR(255),
    preg_3 VARCHAR(255),
    preg_4 VARCHAR(255),
    preg_5 VARCHAR(255),
    res_1 VARCHAR(255),
    res_2 VARCHAR(255),
    res_3 VARCHAR(255),
    res_4 VARCHAR(255),
    res_5 VARCHAR(255)
);

CREATE TABLE usuarios_cursos(
	usu_id INT,
    cur_id INT,
    estado ENUM('pendiente','enCurso','completo'),
    nota DECIMAL(4,2),
    res_1 VARCHAR(255),
    res_2 VARCHAR(255),
    res_3 VARCHAR(255),
    res_4 VARCHAR(255),
    res_5 VARCHAR(255),
    PRIMARY KEY (usu_id, cur_id),
    FOREIGN KEY (usu_id) REFERENCES usuarios(usu_id),
    FOREIGN KEY (cur_id) REFERENCES cursos(cur_id)
);

insert into roles (rol_id, rol_desc) values
(1,'admin'),
(2,'usuario');

insert into usuarios(nombre,apellido,clave,dni,email,rol_id) values
('admin','todopoderoso',1234,12345678,'admin@mostaza.com',1);