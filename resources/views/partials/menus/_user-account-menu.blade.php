<!--بداية قائمة حساب المستخدم-->
<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
    data-kt-menu="true">
    <!--بداية عنصر القائمة-->
    <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
            <!--بداية الصورة الرمزية-->
            <div class="symbol symbol-50px me-5">
                @if (Auth::user()->getProfilePhotoUrlAttribute())
                    <img alt="الشعار" src="{{ Auth::user()->getProfilePhotoUrlAttribute() }}" />
                @else
                    <div
                        class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', Auth::user()->name) }}">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                @endif
            </div>
            <!--نهاية الصورة الرمزية-->
            <!--بداية اسم المستخدم-->
            <div class="d-flex flex-column">
                <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}
                    <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">محترف</span>
                </div>
                <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
            </div>
            <!--نهاية اسم المستخدم-->
        </div>
    </div>
    <!--نهاية عنصر القائمة-->
    <!--بداية فاصل القائمة-->
    <div class="separator my-2"></div>
    <!--نهاية فاصل القائمة-->
    <!--بداية عنصر القائمة-->
    <div class="menu-item px-5">
        <a href="{{ route('user-management.users.edit', Auth::user()) }}" class="menu-link px-5">ملفي الشخصي</a>
    </div>
    <!--نهاية عنصر القائمة-->
    <!--بداية عنصر القائمة-->
    <div class="menu-item px-5">
        {{-- <a href="{{ route('orders.index') }}" class="menu-link px-5">
            <span class="menu-text">طلباتي</span>
            <span class="menu-badge">
                <span class="badge badge-light-danger badge-circle fw-bold fs-7">
                    {{ App\Models\Order::where('user_id', Auth::user()->id)->count() }}
                </span>
            </span>
        </a> --}}
    </div>
    <!--نهاية عنصر القائمة-->
    {{-- ... (تم حذف التعليقات الطويلة للإيجاز) ... --}}
    <!--بداية فاصل القائمة-->
    <div class="separator my-2"></div>
    <!--نهاية فاصل القائمة-->
    <!--بداية عنصر القائمة-->
    <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
        data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
        <a href="#" class="menu-link px-5">
            <span class="menu-title position-relative">الوضع
                <span class="ms-5 position-absolute translate-middle-y top-50 end-0">{!! getIcon('night-day', 'theme-light-show fs-2') !!}
                    {!! getIcon('moon', 'theme-dark-show fs-2') !!}</span></span>
        </a>
        @include('partials/theme-mode/__menu')
    </div>
    <!--نهاية عنصر القائمة-->
    {{-- ... (تم حذف التعليقات الطويلة للإيجاز) ... --}}
    <!--بداية عنصر القائمة-->
    <div class="menu-item px-5">
        <a class="button-ajax menu-link px-5" href="#" data-action="{{ route('logout') }}" data-method="post"
            data-csrf="{{ csrf_token() }}" data-reload="true">
            تسجيل الخروج
        </a>
    </div>
    <!--نهاية عنصر القائمة-->
</div>
<!--نهاية قائمة حساب المستخدم-->
