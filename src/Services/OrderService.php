<?php
class OrderService
{
    public function create(Order $order): void
    {
        $this->validar($order);
        $total = PriceCalculator::forPatientType($order->patientType)->calculate($order->amount);
        $guardado = new Order($order->id, $order->patient, $total, $order->patientType);
        $guardado->guardar();
        $this->notificar('email', 'paciente@mail.com', $guardado);
        $this->avisarCreacion($guardado);
    }

    public function procesarPedidoCompleto(
        int $id,
        string $paciente,
        float $monto,
        string $tipoPaciente,
        string $tipoNotificacion,
        string $destino
    ): void {
        $order = new Order($id, $paciente, $monto, $tipoPaciente);
        $this->validar($order);
        $total = PriceCalculator::forPatientType($order->patientType)->calculate($order->amount);
        $persistido = new Order($order->id, $order->patient, $total, $order->patientType);
        $persistido->guardar();
        $this->notificar($tipoNotificacion, $destino, $persistido);
        $this->avisarCreacion($persistido);
        echo (new ReportGenerator())->generate("Pedido {$id}", true, true, false) . '<br>';
        echo "<p>Pedido {$id} procesado. Total: $ {$total}</p>";
    }

    public function listar(): array
    {
        return [
            ['id' => 1, 'paciente' => 'Juan Perez', 'monto' => 15000, 'tipo' => 'obra_social'],
            ['id' => 2, 'paciente' => 'Ana Gomez', 'monto' => 22000, 'tipo' => 'particular'],
        ];
    }

    private function validar(Order $order): void
    {
        if (trim($order->patient) === '') {
            throw new InvalidArgumentException('Falta el paciente');
        }

        if ($order->amount <= 0) {
            throw new InvalidArgumentException('Monto invalido');
        }
    }

    private function notificar(string $tipo, string $destino, Order $order): void
    {
        $mensaje = "Pedido {$order->id} por $ {$order->amount}";
        (new NotificationSender())->enviar($tipo, $destino, $mensaje);
    }

    private function avisarCreacion(Order $order): void
    {
        $eventos = new OrderEvents();
        $eventos->pedidoCreado($order);
    }
}
