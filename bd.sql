CREATE DATABASE ambd;
USE ambd;

-- 2. Roles y usuarios 
CREATE TABLE roles (
  rol_id     INT PRIMARY KEY,
  rol_desc   VARCHAR(30) NOT NULL
);

select * from preguntas;
DELETE FROM preguntas where cur_id=1;

select * from opciones;

CREATE TABLE usuarios (
  usu_id       INT PRIMARY KEY AUTO_INCREMENT,
  nombre       VARCHAR(30) NOT NULL,
  apellido     VARCHAR(30) NOT NULL,
  clave        CHAR(60)    NOT NULL,       
  dni          VARCHAR(15) NOT NULL UNIQUE,
  sucursal     VARCHAR(30),
  email        VARCHAR(100) NOT NULL UNIQUE,
  estado       ENUM('activo','inactivo') DEFAULT 'activo',
  rol_id       INT          NOT NULL,
  FOREIGN KEY (rol_id) REFERENCES roles(rol_id)
);

-- 3. Cursos
CREATE TABLE cursos (
  cur_id    INT PRIMARY KEY AUTO_INCREMENT,
  nombre    VARCHAR(100) NOT NULL,
  area      ENUM('cocina','atencion','limpieza') NOT NULL,
  estado    ENUM('activo','inactivo') DEFAULT 'activo',
  pdf       VARCHAR(255),
  cur_desc  TEXT,
  video     VARCHAR(255)
);

-- 4. Preguntas de examen por curso
CREATE TABLE preguntas (
  preg_id   INT PRIMARY KEY AUTO_INCREMENT,
  cur_id    INT NOT NULL,
  texto     TEXT      NOT NULL,
  FOREIGN KEY (cur_id) REFERENCES cursos(cur_id)
);

-- 5. Opciones de cada pregunta
CREATE TABLE opciones (
  opt_id      INT PRIMARY KEY AUTO_INCREMENT,
  preg_id     INT    NOT NULL,
  texto       VARCHAR(255) NOT NULL,
  es_correcta BOOLEAN     NOT NULL DEFAULT FALSE,
  FOREIGN KEY (preg_id) REFERENCES preguntas(preg_id)
);

-- 6. Relación de usuarios con cursos (estado, nota, etc.)
CREATE TABLE usuarios_cursos (
  usu_id  INT NOT NULL,
  cur_id  INT NOT NULL,
  estado  ENUM('pendiente','enCurso','completo') DEFAULT 'pendiente',
  nota    DECIMAL(4,2),
  PRIMARY KEY (usu_id, cur_id),
  FOREIGN KEY (usu_id) REFERENCES usuarios(usu_id),
  FOREIGN KEY (cur_id) REFERENCES cursos(cur_id)
);

-- 7. Respuestas de los usuarios (qué opción eligió)
CREATE TABLE respuestas (
  resp_id  INT PRIMARY KEY AUTO_INCREMENT,
  usu_id   INT    NOT NULL,
  preg_id  INT    NOT NULL,
  opt_id   INT    NOT NULL,
  fecha    DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (usu_id)  REFERENCES usuarios(usu_id),
  FOREIGN KEY (preg_id) REFERENCES preguntas(preg_id),
  FOREIGN KEY (opt_id)  REFERENCES opciones(opt_id),
  UNIQUE (usu_id, preg_id) 
);

insert into roles (rol_id,rol_desc) values
(1,'admin'),
(2,'usuario');

insert into usuarios(nombre,apellido,clave,dni,email,estado,rol_id) values
('alexis','gomez',1234,12345678,'alexis@mostaza.com','activo',1);