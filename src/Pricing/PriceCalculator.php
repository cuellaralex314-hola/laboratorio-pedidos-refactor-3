<?php
final class ParticularStrategy implements PricingStrategy
{
    public function calculate(float $amount): float
    {
        return $amount;
    }
}

final class ObraSocialStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.30)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}

final class JubiladoStrategy implements PricingStrategy
{
    public function calculate(float $amount): float
    {
        return $amount * 0.5;
    }
}

final class PrepaidStrategy implements PricingStrategy
{
    public function __construct(private float $discount = 0.20)
    {
    }

    public function calculate(float $amount): float
    {
        return $amount * (1 - $this->discount);
    }
}

class PriceCalculator
{
    private PricingStrategy $strategy;

    public function __construct(?PricingStrategy $strategy = null)
    {
        $this->strategy = $strategy ?? new ParticularStrategy();
    }

    public static function forPatientType(string $tipoPaciente): self
    {
        return new self(match ($tipoPaciente) {
            'obra_social' => new ObraSocialStrategy(0.30),
            'jubilado' => new JubiladoStrategy(),
            'prepaga' => new PrepaidStrategy(0.20),
            default => new ParticularStrategy(),
        });
    }

    public function calculate(float $amount): float
    {
        return $this->strategy->calculate($amount);
    }

    public function calcular(float $monto, string $tipoPaciente): float
    {
        return self::forPatientType($tipoPaciente)->calculate($monto);
    }

    public function calcularConIva(float $monto, string $tipoPaciente): float
    {
        return $this->calcular($monto, $tipoPaciente) * 1.21;
    }
}
