<?php
final class WhatsAppNotification implements Notification
{
    public function __construct(private string $to)
    {
    }

    public function send(string $message): void
    {
        echo "[WHATSAPP] a {$this->to}: {$message}<br>";
    }
}
