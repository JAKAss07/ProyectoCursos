CREATE DATABASE Cursos;
USE Cursos;



CREATE TABLE Rol (
    ID_Rol INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre_Rol VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Modelo_Negocio (
    ID_Modelo INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre_Modelo VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE Usuario (
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombre_Usuario VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Celular VARCHAR(20),
    Contrasena VARCHAR(255) NOT NULL,
    ID_Rol INT NOT NULL,
    FOREIGN KEY (ID_Rol) REFERENCES Rol(ID_Rol)
);

CREATE TABLE Curso (
    ID_Curso INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_Instructor INT NOT NULL,
    Titulo VARCHAR(150) NOT NULL,
    Descripcion TEXT,
    ID_Modelo INT NOT NULL,
    Estado VARCHAR(30),
    Fecha_Creacion DATE,
    Contenido TEXT,
	Precio DECIMAL(10,2) NOT NULL DEFAULT 0,
    FOREIGN KEY (ID_Instructor) REFERENCES Usuario(ID),
    FOREIGN KEY (ID_Modelo) REFERENCES Modelo_Negocio(ID_Modelo)
);

CREATE TABLE Validaciones (
    ID_Validacion INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_Curso INT NOT NULL,
    ID_Moderador INT NOT NULL,
    Fecha_Validacion DATE,
    Resultado VARCHAR(50),
    Observacion TEXT,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso),
    FOREIGN KEY (ID_Moderador) REFERENCES Usuario(ID)
);

CREATE TABLE Temas (
    ID_Tema INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_Curso INT NOT NULL,
    Titulo VARCHAR(150) NOT NULL,
    Duracion int not null,
    Genero varchar(50),
    Descripcion text,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso)
    );
   
INSERT INTO Rol (Nombre_Rol) VALUES 
('Administrador'),
('Instructor'),
('Moderador'),
('Estudiante');

INSERT INTO Modelo_Negocio (Nombre_Modelo) VALUES 
('Suscripción'),
('Pago por curso'),
('Gratuito con certificado opcional'),
('Empresarial');

INSERT INTO Usuario (Nombre_Usuario, Correo, Celular, Contrasena, ID_Rol) VALUES 
('Juan Pérez', 'juan@example.com', '5551234567', 'hashedpassword1', 1),
('María García', 'maria@example.com', '5557654321', 'hashedpassword2', 2),
('Carlos López', 'carlos@example.com', '5559876543', 'hashedpassword3', 2),
('Ana Martínez', 'ana@example.com', '5554567890', 'hashedpassword4', 3),
('Luisa Rodríguez', 'luisa@example.com', '5556789012', 'hashedpassword5', 4),
('Pedro Sánchez', 'pedro@example.com', '5553456789', 'hashedpassword6', 4);

INSERT INTO Curso (ID_Instructor, Titulo, Descripcion, ID_Modelo, Estado, Fecha_Creacion, Contenido) VALUES 
(2, 'Introducción a Python', 'Curso básico de programación en Python', 2, 'Publicado', '2023-01-15', 'Variables, estructuras de control, funciones, POO'),
(2, 'Machine Learning Avanzado', 'Técnicas avanzadas de ML con Python', 1, 'En revisión', '2023-02-20', 'Redes neuronales, SVM, Random Forest'),
(3, 'Diseño Web Moderno', 'HTML5, CSS3 y JavaScript ES6+', 3, 'Publicado', '2023-03-10', 'Flexbox, Grid, Animaciones, Responsive Design'),
(3, 'Bases de Datos SQL', 'Desde cero hasta consultas avanzadas', 2, 'Rechazado', '2023-01-30', 'Modelado, consultas, joins, procedimientos');

INSERT INTO Validaciones (ID_Curso, ID_Moderador, Fecha_Validacion, Resultado, Observacion) VALUES 
(1, 4, '2023-01-20', 'Aprobado', 'Contenido completo y bien estructurado'),
(2, 4, '2023-02-25', 'Pendiente', 'Falta material de evaluación'),
(4, 4, '2023-02-05', 'Rechazado', 'Contenido desactualizado, necesita revisión');

INSERT INTO Temas (ID_Curso, Titulo, Duracion, Genero, Descripcion) VALUES 
(1, 'Variables y Tipos de Datos', 120, 'Programación', 'Introducción a variables y tipos básicos en Python'),
(1, 'Estructuras de Control', 180, 'Programación', 'If, for, while y manejo de flujo'),
(2, 'Introducción a TensorFlow', 240, 'Ciencia de Datos', 'Conceptos básicos de redes neuronales'),
(3, 'CSS Grid Layout', 150, 'Diseño Web', 'Sistema de grid moderno para diseño web'),
(3, 'Animaciones CSS', 90, 'Diseño Web', 'Transiciones y keyframes');