<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Requirement;

class OrderService
{
    public function createOrder(array $data): Order
    {
        $requirements = $data['requirements'] ?? [];
        unset($data['requirements']);

        $order = Order::create($data);

        $this->addRequirementsToOrder($order, $requirements);

        return $order;
    }

    public function updateOrder($orderId, array $data): Order
    {
        $order = Order::findOrFail($orderId);

        $requirements = $data['requirements'] ?? [];
        unset($data['requirements']);

        $order->update($data);

        $this->updateRequirementsForOrder($order, $requirements);

        return $order;
    }

    public function deleteOrder(Order $order)
    {
        $order->requirements()->delete();
        $order->attachments()->delete();
        $order->delete();
        return true;
    }


    private function addRequirementsToOrder(Order $order, array $requirements): void
    {
        foreach ($requirements as $requirement) {
            $order->requirements()->create(['title' => $requirement]);
        }
    }

    private function updateRequirementsForOrder(Order $order, array $requirements): void
    {
        $order->requirements()->delete();
        $this->addRequirementsToOrder($order, $requirements);
    }
}
