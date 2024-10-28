<div class="d-flex align-items-center text-center justify-content-center">
    <!--begin::order details-->
    <div class="d-flex flex-column">
        <a href="{{ route('orders.show', $order) }}" class="text-gray-800 text-hover-primary mb-1">
            {{ $order->title }}
        </a>
    </div>
    <!--begin::order details-->
</div>
