-- Ejecutar una sola vez en la base de datos preguntados2 existente.
CREATE TABLE IF NOT EXISTS reporte_pregunta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    pregunta_id INT NOT NULL,
    motivo VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    estado ENUM('Pendiente', 'Revisado', 'Descartado') NOT NULL DEFAULT 'Pendiente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reporte_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id),
    CONSTRAINT fk_reporte_pregunta FOREIGN KEY (pregunta_id) REFERENCES pregunta(id)
);
