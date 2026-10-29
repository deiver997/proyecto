-- Crear la base de datos (opcional si ya tienes una)
CREATE DATABASE IF NOT EXISTS gestion_personas 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE gestion_personas;

CREATE TABLE IF NOT EXISTS personas (
    id SERIAL PRIMARY KEY,
    nombre1 VARCHAR(50) NOT NULL,
    apellido1 VARCHAR(50) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


