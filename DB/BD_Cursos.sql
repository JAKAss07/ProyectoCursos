CREATE DATABASE Cursos;
USE Cursos;


    
   
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