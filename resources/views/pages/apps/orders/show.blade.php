<x-default-layout>

    @section('title')
        الطلبات - {{ $order->title }}
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('order-management.orders.show', $order) }}
    @endsection

    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">تفاصيل الطلب</h3>
        </div>
        <div class="card-body">
            <div class="row g-5 g-xl-10">
                <div class="col-xl-4">
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">رقم الطلب</span>
                        </label>
                        <span class="form-control form-control-solid">{{ $order->id }}</span>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                            <span class="required">عنوان الطلب</span>
                        </label>
                        <span class="form-control form-control-solid">{{ $order->title }}</span>
                    </div>
                    <div class="d-flex flex-column mb-8 fv-row">
                        <label class="fs-6 fw-semibold mb-2">التفاصيل</label>
                        <textarea class="form-control form-control-solid" rows="3" readonly>{{ $order->details }}</textarea>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="col-xl-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">الحالة</span>
                            </label>
                            @if (Auth::user()->roles()->first()->name === 'administrator' || Auth::user()->roles()->first()->name === 'super admin')
                                <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="input-group">
                                        <select class="form-select" name="status" required>
                                            <option value="معلق" {{ $order->status == 'معلق' ? 'selected' : '' }}>معلق
                                            </option>
                                            <option value="غير منجز"
                                                {{ $order->status == 'غير منجز' ? 'selected' : '' }}>غير منجز</option>
                                            <option value="مكتمل" {{ $order->status == 'مكتمل' ? 'selected' : '' }}>
                                                مكتمل
                                            </option>
                                            <option value="ملغي" {{ $order->status == 'ملغي' ? 'selected' : '' }}>
                                                ملغي
                                            </option>
                                        </select>
                                        <button type="submit" class="btn btn-primary ms-3">تحديث الحالة</button>
                                    </div>
                                </form>
                            @else
                                <span
                                    class="badge badge-{{ getStatusColor($order->status) }} fs-8 fw-bold">{{ $order->status }}
                                </span>
                            @endif
                        </div>

                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="d-flex align-items-center fs-6 fw-semibold mb-2">
                                <span class="required">تاريخ الإنشاء</span>
                            </label>
                            <span
                                class="form-control form-control-solid">{{ $order->created_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="fs-6 fw-semibold mb-2">المتطلبات</label>
                            <div class="table-responsive">
                                <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                                    <thead>
                                        <tr class="fw-bold text-muted">
                                            <th class="min-w-150px">المتطلب</th>
                                            <th class="min-w-140px">الحالة</th>
                                            <th class="min-w-140px">تم بواسطة</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->requirements as $requirement)
                                            <tr>
                                                <td>{{ $requirement->title }}</td>
                                                <td><span
                                                        class="badge badge-light-primary">{{ $requirement->status }}</span>
                                                </td>
                                                <td>
                                                    @if ($requirement->completed_by)
                                                        <span class="badge badge-light-info">
                                                            <i class="fas fa-user-check me-1"></i>
                                                            {{ $requirement->completedByUser->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted">لم ينجز بعد</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($requirement->status !== 'مكتمل')
                                                        <form
                                                            action="{{ route('requirements.complete', $requirement->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="submit"
                                                                class="btn btn-success btn-sm">إنجاز</button>
                                                        </form>
                                                    @else
                                                        <span class="text-success">مكتمل</span>
                                                    @endif
                                                </td>
                                                @if (Auth::user()->roles()->first()->name === 'administrator' || Auth::user()->roles()->first()->name === 'super admin')
                                                    <td>
                                                        <form
                                                            action="{{ route('requirements.updateStatus', $requirement->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="input-group">
                                                                <select class="form-select px-3" name="status"
                                                                    required>
                                                                    <option value="غير منجز"
                                                                        {{ $requirement->status == 'غير منجز' ? 'selected' : '' }}>
                                                                        غير منجز</option>
                                                                    <option value="مكتمل"
                                                                        {{ $requirement->status == 'مكتمل' ? 'selected' : '' }}>
                                                                        مكتمل</option>
                                                                </select>
                                                                <button type="submit"
                                                                    class="btn btn-primary ms-3">تحديث</button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-5 g-xl-8">
                    <div class="col-12">
                        <div class="d-flex flex-column mb-8 fv-row">
                            <label class="fs-6 fw-semibold mb-2">المرفقات</label>
                            <div class="d-flex flex-wrap">
                                @forelse($order->attachments as $attachment)
                                    <a href="{{ route('attachments.download', $attachment->id) }}"
                                        class="btn btn-light-primary btn-sm me-3 mb-3">
                                        <i class="fas fa-paperclip me-2"></i>{{ $attachment->file_name }}
                                    </a>
                                @empty
                                    <span class="text-muted">لا توجد مرفقات</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-default-layout>
