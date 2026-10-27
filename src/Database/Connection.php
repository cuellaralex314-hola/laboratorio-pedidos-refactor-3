<?php
class Connection
{
    private static ?self $instance = null;
    private static array $tablaEnMemoria = [];
    private PDO $pdo;

    private function __construct(array $config = [])
    {
        $driver = $config['driver'] ?? 'sqlite';

        if ($driver === 'sqlite' || empty($config['host'])) {
            $this->pdo = new PDO('sqlite::memory:');
        } else {
            $dsn = "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4";
            $this->pdo = new PDO($dsn, $config['user'] ?? '', $config['pass'] ?? '', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        }

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(array $config = []): self
    {
        if (self::$instance === null) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    public static function obtener(array $config = []): self
    {
        return self::getInstance($config);
    }

    public function ejecutar(string $sql): void
    {
        self::$tablaEnMemoria[] = $sql;
    }

    public function consultas(): array
    {
        return self::$tablaEnMemoria;
    }
}
