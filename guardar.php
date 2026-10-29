<?php
// Configuración: Lee las variables de entorno de Render, o usa valores por defecto locales si estás probando en tu PC
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'gestion_personas';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: 'tu_contraseña'; // Cambia esto si lo pruebas localmente

header('Content-Type: application/json; charset=utf-8');

try {
    // Conexión a PostgreSQL mediante PDO (incluyendo sslmode para Render)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // MAGIA AUTOMÁTICA: Crea la tabla si todavía no existe en la base de datos de PostgreSQL
    $sql_tabla = "CREATE TABLE IF NOT EXISTS personas (
        id SERIAL PRIMARY KEY,
        nombre1 VARCHAR(50) NOT NULL,
        apellido1 VARCHAR(50) NOT NULL,
        fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );";
    $pdo->exec($sql_tabla);

    // Obtener los datos enviados por POST desde JavaScript
    $nombre1 = isset($_POST['nombre1']) ? trim($_POST['nombre1']) : '';
    $apellido1 = isset($_POST['apellido1']) ? trim($_POST['apellido1']) : '';

    if (empty($nombre1) || empty($apellido1)) {
        echo json_encode(['success' => false, 'message' => 'Los campos son obligatorios.']);
        exit;
    }

    // Insertar en la tabla personas
    $sql = "INSERT INTO personas (nombre1, apellido1) VALUES (:nombre1, :apellido1)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':nombre1' => $nombre1,
        ':apellido1' => $apellido1
    ]);

    echo json_encode(['success' => true, 'message' => 'Persona guardada correctamente en PostgreSQL.']);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error de base de datos: ' . $e->getMessage()]);
}
?>