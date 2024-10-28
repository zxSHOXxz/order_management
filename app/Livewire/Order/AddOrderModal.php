<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\AttachmentService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;


class AddOrderModal extends Component
{

    use WithFileUploads;

    public $order_id;
    public $title;
    public $details;
    public $status;
    public $edit_mode = false;
    public $requirements = [];
    public $attachments = [];

    private OrderService $orderService;
    private AttachmentService $attachmentService;

    public function boot(OrderService $orderService, AttachmentService $attachmentService)
    {
        $this->orderService = $orderService;
        $this->attachmentService = $attachmentService;
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'details' => 'required|string',
            'requirements' => 'nullable|array',
            'requirements.*' => 'required|string|max:255',
            'attachments.*' => 'nullable|file|max:10240', // 10MB Max
        ];
    }

    protected $listeners = [
        'delete_order' => 'deleteOrder',
    ];

    public function deleteOrder($id)
    {
        $this->order_id = $id;
        $order = Order::find($id);
        $this->orderService->deleteOrder($order);

        $this->dispatch('success', 'Order deleted successfully');
        $this->reset();
    }


    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $orderData = [
                'title' => $this->title,
                'details' => $this->details,
                'status' => 'غير منجز',
            ];

            if ($this->edit_mode) {
                $order = $this->orderService->updateOrder($this->order_id, $orderData);
            } else {
                $order = $this->orderService->createOrder($orderData);
            }

            // Handle requirements separately
            $this->handleRequirements($order);

            $this->handleAttachments($order);

            DB::commit();

            $this->dispatchSuccessMessage();
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in AddOrderModal::submit: ' . $e->getMessage());
            $this->dispatch('error', 'An error occurred while processing your request' . $e->getMessage());
        }
    }

    private function handleRequirements(Order $order): void
    {
        if (!empty($this->requirements)) {
            foreach ($this->requirements as $requirement) {
                $order->requirements()->create(['title' => $requirement, 'status' => 'غير منجز']);
            }
        }
    }

    private function handleAttachments(Order $order): void
    {
        if (!empty($this->attachments)) {
            $this->attachmentService->addAttachmentsToOrder($order, $this->attachments);
        }
    }

    private function dispatchSuccessMessage(): void
    {
        $message = $this->edit_mode
            ? __('Order updated')
            : __('New Order created');

        $this->dispatch('success', $message);
    }
}
