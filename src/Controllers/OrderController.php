<?php
class OrderController
{
    public function __construct(private array $config = [])
    {
        $this->service = new OrderService();
    }

    public function create(): void
    {
        $order = new Order(
            (int) ($_GET['id'] ?? 1),
            (string) ($_GET['paciente'] ?? 'Juan Perez'),
            (float) ($_GET['monto'] ?? 15000),
            (string) ($_GET['tipo'] ?? 'obra_social')
        );

        $this->service->create($order);
        $this->index();
    }

    public function index(): void
    {
        $pedidos = [
            ['id' => 1, 'paciente' => 'Juan Perez', 'monto' => 10500, 'tipo' => 'obra_social', 'total' => 10500],
            ['id' => 2, 'paciente' => 'Ana Gomez', 'monto' => 22000, 'tipo' => 'particular', 'total' => 22000],
        ];

        require __DIR__ . '/../../views/orders.php';
    }

    public function report(): void
    {
        $generador = new ReportGenerator();
        echo $generador->generate('Pedidos del dia', true, true, true);
    }

    private OrderService $service;
}
