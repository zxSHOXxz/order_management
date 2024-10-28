<a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm" data-kt-menu-trigger="click"
    data-kt-menu-placement="bottom-end">
    العمليات
    <i class="ki-duotone ki-down fs-5 ms-1"></i>
</a>
<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
    data-kt-menu="true">
    <!--begin::Menu item-->
    <div class="menu-item px-3">
        <a href="{{ route('user-management.users.show', $user) }}" class="menu-link px-3">
            عرض
        </a>
    </div>
    <!--end::Menu item-->

    @can('edit user')
        @if ($user->status === 'غير فعال' && $user->roles()->first()->name === 'user')
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}"
                    data-kt-action="update_user_status"> تفعيل الحساب </a>
            </div>
            <!--end::Menu item-->
        @endif
    @endcan

    @can('delete user')
        @if (
            $user->roles()->first()->name !== 'super admin' ||
                (Auth::user()->roles()->first()->name === 'super admin' && $user->roles()->first()->name === 'super admin'))
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-user-id="{{ $user->id }}" data-kt-action="delete_row">
                    حذف
                </a>
            </div>
            <!--end::Menu item-->
        @endif
    @endcan

</div>
<!--end::Menu-->
