<?php
echo "<h1>Docker para Metodologias 2</h1>";
echo "<h2>Nginx + PHP-FPM + MariaDB</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";

$env = function($k, $d=null){ $v = getenv($k); return $v !== false ? $v : $d; };

$dsn = 'mysql:host=db;dbname=' . $env('DB_NAME', 'app') . ';charset=utf8mb4';
$user = $env('DB_USER', 'appuser');
$pass = $env('DB_PASSWORD', 'apppass');

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p>✅ Conexión a MariaDB OK</p>";
    $stmt = $pdo->query('SELECT NOW() as now');
    $row = $stmt->fetch();
    echo "<p>Hora DB: " . htmlspecialchars($row['now']) . "</p>";
} catch (PDOException $e) {
    echo "<p>❌ Error DB: " . htmlspecialchars($e->getMessage()) . "</p>";
}

phpinfo(INFO_MODULES);
