<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Http\UploadedFile;

class AttachmentService
{
    public function addAttachmentsToOrder(Order $order, array $attachments): void
    {
        foreach ($attachments as $attachment) {
            if ($attachment instanceof UploadedFile) {
                $path = $attachment->store('order_attachments', 'public');
                $order->attachments()->create([
                    'file_path' => $path,
                    'file_name' => $attachment->getClientOriginalName(),
                ]);
            }
        }
    }
}
