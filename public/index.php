<?php
spl_autoload_register(function (string $class): void {
    $candidatos = [
        __DIR__ . '/../src/' . str_replace('\\', '/', $class) . '.php',
        __DIR__ . '/../src/Controllers/' . $class . '.php',
        __DIR__ . '/../src/Database/' . $class . '.php',
        __DIR__ . '/../src/Events/' . $class . '.php',
        __DIR__ . '/../src/Legacy/' . $class . '.php',
        __DIR__ . '/../src/Models/' . $class . '.php',
        __DIR__ . '/../src/Notifications/' . $class . '.php',
        __DIR__ . '/../src/Pricing/' . $class . '.php',
        __DIR__ . '/../src/Reports/' . $class . '.php',
        __DIR__ . '/../src/Services/' . $class . '.php',
    ];

    foreach ($candidatos as $archivo) {
        if (is_file($archivo)) {
            require_once $archivo;
            return;
        }
    }
});

$configPath = __DIR__ . '/../config/database.php';
$config = require is_file($configPath)
    ? $configPath
    : __DIR__ . '/../config/database.example.php';
$controller = new OrderController($config);

$rutas = [
    'crear'   => fn() => $controller->create(),
    'listar'  => fn() => $controller->index(),
    'reporte' => fn() => $controller->report(),
];

($rutas[$_GET['accion'] ?? 'crear'] ?? fn() => http_response_code(404))();
