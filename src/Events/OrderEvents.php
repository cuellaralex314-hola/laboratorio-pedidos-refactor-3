<?php
class EmailObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        echo "[EMAIL OBSERVER] Pedido {$order->id} actualizado<br>";
    }
}

class SmsObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        echo "[SMS OBSERVER] Pedido {$order->id} notificado<br>";
    }
}

class DashboardObserver implements OrderObserver
{
    public function update(Order $order): void
    {
        echo "[DASHBOARD] actualizado para el pedido {$order->id}<br>";
    }
}

class OrderSubject
{
    private array $observers = [];

    public function subscribe(OrderObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notify(Order $order): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($order);
        }
    }
}

class OrderEvents
{
    private OrderSubject $subject;

    public function __construct()
    {
        $this->subject = new OrderSubject();
        $this->subject->subscribe(new EmailObserver());
        $this->subject->subscribe(new SmsObserver());
        $this->subject->subscribe(new DashboardObserver());
    }

    public function pedidoCreado(Order $order): void
    {
        $this->subject->notify($order);
    }
}
