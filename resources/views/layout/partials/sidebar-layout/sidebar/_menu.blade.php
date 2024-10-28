<!--بداية قائمة الشريط الجانبي-->
<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <!--بداية غلاف القائمة-->
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
        <!--بداية القائمة-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3 fw-semibold fs-6" id="#kt_app_sidebar_menu"
            data-kt-menu="true" data-kt-menu-expand="false">

            {{-- // ... (الكود المعلق تم تخطيه) ... --}}

            <!--بداية عنصر القائمة-->
            <div class="menu-item pt-5">
                <!--بداية محتوى القائمة-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">الرئيسية</span>
                </div>
                <!--نهاية محتوى القائمة-->
            </div>
            <!--نهاية عنصر القائمة-->

            <!--بداية عنصر القائمة-->
            <div class="menu-item {{ request()->routeIs('dashboard') ? 'here show' : '' }}">
                <!--بداية رابط القائمة-->
                <a class="menu-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <span class="menu-icon">{!! getIcon('code', 'fs-2') !!}</span>
                    <span class="menu-title">لوحة التحكم</span>
                </a>
                <!--نهاية رابط القائمة-->
            </div>
            <!--نهاية عنصر القائمة-->

            <!--بداية عنصر قائمة التطبيقات-->
            <div class="menu-item pt-5">
                <!--بداية محتوى القائمة-->
                <div class="menu-content">
                    <span class="menu-heading fw-bold text-uppercase fs-7">التطبيقات</span>
                </div>
                <!--نهاية محتوى القائمة-->
            </div>
            <!--نهاية عنصر قائمة التطبيقات-->

            @can('read user')
                <!--بداية عنصر القائمة-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('user-management.*') ? 'here show' : '' }}">
                    <!--بداية رابط القائمة-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('people', 'fs-2') !!}</span>
                        <span class="menu-title">إدارة المستخدمين</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--نهاية رابط القائمة-->
                    <!--بداية القائمة الفرعية-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--بداية عنصر القائمة-->
                        <div class="menu-item">
                            <!--بداية رابط القائمة-->
                            <a class="menu-link {{ request()->routeIs('user-management.users.*') ? 'active' : '' }}"
                                href="{{ route('user-management.users.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">المستخدمون</span>
                            </a>
                            <!--نهاية رابط القائمة-->
                        </div>
                        <!--نهاية عنصر القائمة-->
                        @can('read role')
                            <!--بداية عنصر القائمة-->
                            <div class="menu-item">
                                <!--بداية رابط القائمة-->
                                <a class="menu-link {{ request()->routeIs('user-management.roles.*') ? 'active' : '' }}"
                                    href="{{ route('user-management.roles.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">الأدوار</span>
                                </a>
                                <!--نهاية رابط القائمة-->
                            </div>
                            <!--نهاية عنصر القائمة-->
                            <!--بداية عنصر القائمة-->
                            <div class="menu-item">
                                <!--بداية رابط القائمة-->
                                <a class="menu-link {{ request()->routeIs('user-management.permissions.*') ? 'active' : '' }}"
                                    href="{{ route('user-management.permissions.index') }}">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">الصلاحيات</span>
                                </a>
                                <!--نهاية رابط القائمة-->
                            </div>
                            <!--نهاية عنصر القائمة-->
                        @endcan
                    </div>
                    <!--نهاية القائمة الفرعية-->
                </div>
                <!--نهاية عنصر القائمة-->
            @endcan

            @can('read order')
                <!--بداية عنصر القائمة-->
                <div data-kt-menu-trigger="click"
                    class="menu-item menu-accordion {{ request()->routeIs('orders.*') ? 'here show' : '' }}">
                    <!--بداية رابط القائمة-->
                    <span class="menu-link">
                        <span class="menu-icon">{!! getIcon('package', 'fs-2') !!}</span>
                        <span class="menu-title">إدارة الطلبات</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--نهاية رابط القائمة-->
                    <!--بداية القائمة الفرعية-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--بداية عنصر القائمة-->
                        <div class="menu-item">
                            <!--بداية رابط القائمة-->
                            <a class="menu-link {{ request()->routeIs('orders.*') ? 'active' : '' }}"
                                href="{{ route('orders.index') }}">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">الطلبات</span>
                            </a>
                            <!--نهاية رابط القائمة-->
                        </div>
                        <!--نهاية عنصر القائمة-->
                    </div>
                    <!--نهاية القائمة الفرعية-->
                </div>
                <!--نهاية عنصر القائمة-->
            @endcan

            {{-- // ... (الكود المعلق في النهاية تم تخطيه) ... --}}

        </div>
        <!--نهاية القائمة-->
    </div>
    <!--نهاية غلاف القائمة-->
</div>
<!--نهاية قائمة الشريط الجانبي-->
