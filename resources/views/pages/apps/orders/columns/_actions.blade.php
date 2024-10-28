<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-end">
    الإجراءات
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--بداية القائمة-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
    data-kt-menu="true">
    @can('read order')
        <!--بداية عنصر القائمة-->
        <div class="menu-item px-3">
            <a href="{{ route('orders.show', $order) }}" class="menu-link px-3">
                عرض
            </a>
        </div>
        <!--نهاية عنصر القائمة-->
    @endcan

    @can('edit order')
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-order-id="{{ $order->id }}" data-bs-toggle="modal"
                data-kt-action="update_row" data-bs-target="#kt_modal_edit_order">
                تعديل
            </a>
        </div>
    @endcan

    @can('delete order')
        <!--بداية عنصر القائمة-->
        <div class="menu-item px-3">
            <a href="#" class="menu-link px-3" data-kt-order-id="{{ $order->id }}" data-kt-action="delete_row">
                حذف
            </a>
        </div>
        <!--نهاية عنصر القائمة-->
    @endcan
</div>
<!--نهاية القائمة-->
