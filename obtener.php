<?php
// Configuración: Lee las variables de entorno de Render, o usa valores por defecto locales
$host = getenv('DB_HOST') ?: 'localhost';
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME') ?: 'gestion_personas';
$username = getenv('DB_USER') ?: 'postgres';
$password = getenv('DB_PASSWORD') ?: 'tu_contraseña';

header('Content-Type: application/json; charset=utf-8');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consultar todas las personas ordenadas de la más reciente a la más antigua
    $stmt = $pdo->query("SELECT id, nombre1, apellido1, fecha_creacion FROM personas ORDER BY id DESC");
    $personas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $personas]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al obtener datos: ' . $e->getMessage()]);
}
?>