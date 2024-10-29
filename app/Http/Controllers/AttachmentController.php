<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Requirement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AttachmentController extends Controller
{
    public function download(Attachment $attachment)
    {
        $disk = Storage::disk('public');
        
        if (!$disk->exists($attachment->file_path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        return $disk->download($attachment->file_path, $attachment->file_name, [
            'Content-Type' => $attachment->mime_type
        ]);
    }
    public function markAsCompleted(Requirement $requirement)
    {
        // تحديث حالة المتطلب
        $requirement->status = 'مكتمل';
        $requirement->completed_by = Auth::user()->id; // حفظ معرف المستخدم الذي قام بإكمال المتطلب
        $requirement->completed_at = now(); // حفظ وقت الإكمال
        $requirement->save();

        // الحصول على الطلب المرتبط بالمتطلب
        $order = $requirement->order;

        // التحقق من حالة جميع المتطلبات الخاصة بالطلب
        $allCompleted = $order->requirements()->where('status', '!=', 'مكتمل')->doesntExist();

        if ($allCompleted) {
            // إذا كانت جميع المتطلبات مكتملة، قم بتغيير حالة الطلب إلى "مكتمل"
            $order->status = 'مكتمل';
        } else {
            // إذا كانت هناك متطلبات غير مكتملة، قم بتغيير حالة الطلب إلى "غير منجز"
            $order->status = 'غير منجز';
        }

        // حفظ حالة الطلب
        $order->save();

        return redirect()->back()->with('success', 'تم إنجاز المتطلب بنجاح!');
    }

    public function updateStatus(Request $request, Requirement $requirement)
    {

        // التحقق من القيمة المدخلة للحالة
        $validated = $request->validate([
            'status' => 'required|in:معلق,غير منجز,مكتمل,ملغي',
        ]);

        // تحديث حالة المتطلب
        $requirement->status = $validated['status'];
        $requirement->completed_by = ($validated['status'] == 'مكتمل') ? Auth::user()->id : null;
        $requirement->completed_at = ($validated['status'] == 'مكتمل') ? now() : null;
        $requirement->save();

        // الحصول على الطلب المرتبط بالمتطلب
        $order = $requirement->order;

        // التحقق من حالة جميع المتطلبات الخاصة بالطلب
        $allCompleted = $order->requirements()->where('status', '!=', 'مكتمل')->doesntExist();

        if ($allCompleted) {
            // إذا كانت جميع المتطلبات مكتملة، قم بتغيير حالة الطلب إلى "مكتمل"
            $order->status = 'مكتمل';
        } else {
            // إذا كانت هناك متطلبات غير مكتملة، قم بتغيير حالة الطلب إلى "غير منجز"
            $order->status = 'غير منجز';
        }

        // حفظ حالة الطلب
        $order->save();

        return redirect()->back()->with('success', 'تم تحديث حالة المتطلب بنجاح!');
    }
}
