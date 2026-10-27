<?php
class Order
{
    public readonly int $id;
    public readonly string $patient;
    public readonly float $amount;
    public readonly string $patientType;

    public function __construct(int $id, string $patient, float $amount, string $patientType)
    {
        if ($id <= 0) {
            throw new InvalidArgumentException('El id del pedido debe ser positivo');
        }

        if (trim($patient) === '') {
            throw new InvalidArgumentException('El paciente es obligatorio');
        }

        if ($amount < 0) {
            throw new InvalidArgumentException('El importe no puede ser negativo');
        }

        $this->id = $id;
        $this->patient = trim($patient);
        $this->amount = $amount;
        $this->patientType = $patientType;
    }

    public function guardar(): void
    {
        Connection::obtener()->ejecutar(
            "INSERT INTO orders (id, patient, amount, patient_type) VALUES ({$this->id}, '{$this->patient}', {$this->amount}, '{$this->patientType}')"
        );
    }

    public function calcularTotal(): float
    {
        return PriceCalculator::forPatientType($this->patientType)->calculate($this->amount);
    }

    public static function fromArray(array $datos): self
    {
        return new self(
            (int) ($datos['id'] ?? 1),
            (string) ($datos['paciente'] ?? ''),
            (float) ($datos['monto'] ?? 0),
            (string) ($datos['tipo'] ?? 'particular')
        );
    }
}
