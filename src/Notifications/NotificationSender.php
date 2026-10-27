<?php
final class NotificationFactory
{
    public static function create(string $tipo, string $destino): Notification
    {
        return match ($tipo) {
            'email' => new EmailNotification($destino),
            'sms' => new SmsNotification($destino),
            'whatsapp' => new WhatsAppNotification($destino),
            default => throw new InvalidArgumentException("Tipo de notificacion no soportado: {$tipo}"),
        };
    }
}

class NotificationSender
{
    public function enviar(string $tipo, string $destino, string $mensaje): void
    {
        NotificationFactory::create($tipo, $destino)->send($mensaje);
    }
}
