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
    ID INT NOT NULL PRIMARY KEY,
    Nombre_Usuario VARCHAR(100) NOT NULL,
    Correo VARCHAR(100) NOT NULL UNIQUE,
    Celular VARCHAR(20),
    Contrasena VARCHAR(255) NOT NULL,
    Carrera VARCHAR(100),
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
    Precio DECIMAL(10, 2),
    Categoria VARCHAR(100),
    Link_Introduccion TEXT,
    FOREIGN KEY (ID_Instructor) REFERENCES Usuario(ID),
    FOREIGN KEY (ID_Modelo) REFERENCES Modelo_Negocio(ID_Modelo)
);
CREATE TABLE Temas (
    ID_Tema INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    ID_Curso INT NOT NULL,
    Titulo_Tema VARCHAR(150) NOT NULL,
    Link_Video TEXT NOT NULL,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso) ON DELETE CASCADE
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
INSERT INTO Rol (Nombre_Rol)
VALUES ('Administrador'),
    ('Instructor'),
    ('Moderador'),
    ('Estudiante');
INSERT INTO Modelo_Negocio (Nombre_Modelo)
VALUES ('Suscripción'),
    ('Pago por curso'),
    ('Gratuito con certificado opcional'),
    ('Empresarial');