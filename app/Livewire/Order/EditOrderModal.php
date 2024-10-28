<?php

namespace App\Livewire\Order;

use App\Models\Order;
use App\Services\OrderService;
use App\Services\AttachmentService;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EditOrderModal extends Component
{
    use WithFileUploads;

    public $order_id;
    public $title;
    public $details;
    public $status;
    public $requirements = [];
    public $existing_requirements = [];
    public $attachments = [];
    public $existing_attachments = [];

    private OrderService $orderService;
    private AttachmentService $attachmentService;

    protected $listeners = ['editOrder', 'deleteAttachment'];

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

    public function boot(OrderService $orderService, AttachmentService $attachmentService)
    {
        $this->orderService = $orderService;
        $this->attachmentService = $attachmentService;
    }

    public function editOrder($id)
    {
        $order = Order::with(['requirements', 'attachments'])->find($id);

        $this->order_id = $order->id;
        $this->title = $order->title;
        $this->details = $order->details;
        $this->requirements = $order->requirements->pluck('title')->toArray();
        $this->existing_attachments = $order->attachments;

        $this->dispatch('initializeRequirements', $this->requirements);
        $this->dispatch('initializeAttachments', $this->existing_attachments);
    }

    public function deleteAttachment($attachmentId)
    {

        // dd($attachmentId);
        try {
            // حذف المرفق من المصفوفة
            $this->existing_attachments = $this->existing_attachments->filter(function ($attachment) use ($attachmentId) {
                return $attachment->id !== $attachmentId;
            })->values();

            // إرسال المصفوفة المحدثة للـ JavaScript
            $this->dispatch('attachmentsUpdated', $this->existing_attachments->toArray());

            $this->dispatch('success', 'تم حذف المرفق بنجاح');
        } catch (\Exception $e) {
            Log::error('Error deleting attachment: ' . $e->getMessage());
            $this->dispatch('error', 'حدث خطأ أثناء حذف المرفق');
        }
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            $orderData = [
                'title' => $this->title,
                'details' => $this->details,
                'status' => $this->status ?? 'غير منجز',
            ];

            $order = $this->orderService->updateOrder($this->order_id, $orderData);

            // تحديث المتطلبات
            $order->requirements()->delete();
            $this->handleRequirements($order);

            // تحديث المرفقات
            // حذف المرفقات التي تم إزالتها
            $order->attachments()->whereNotIn('id', $this->existing_attachments->pluck('id'))->delete();

            // إضافة المرفقات الجديدة
            if (!empty($this->attachments)) {
                $this->attachmentService->addAttachmentsToOrder($order, $this->attachments);
            }

            DB::commit();
            $this->dispatch('success', 'تم تحديث الطلب بنجاح');
            $this->dispatch('hideModal');
            $this->reset();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in EditOrderModal::update: ' . $e->getMessage());
            $this->dispatch('error', 'حدث خطأ أثناء تحديث الطلب');
        }
    }

    private function handleRequirements(Order $order): void
    {
        if (!empty($this->requirements)) {
            foreach ($this->requirements as $requirement) {
                if (!empty($requirement)) {
                    $order->requirements()->create([
                        'title' => $requirement,
                        'status' => 'غير منجز'
                    ]);
                }
            }
        }
    }

    private function handleAttachments(Order $order): void
    {
        if (!empty($this->attachments)) {
            $this->attachmentService->addAttachmentsToOrder($order, $this->attachments);
        }
    }

    public function render()
    {
        return view('livewire.order.edit-order-modal');
    }
}
