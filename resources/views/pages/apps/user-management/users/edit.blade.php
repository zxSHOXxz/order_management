<x-default-layout>

    @section('title')
        المستخدمون
    @endsection

    @section('breadcrumbs')
        {{ Breadcrumbs::render('user-management.users.show', $user) }}
    @endsection

    <!--بداية التخطيط-->
    <div class="d-flex flex-column flex-lg-row">
        <!--بداية الشريط الجانبي-->
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <!--بداية البطاقة-->
            <div class="card mb-5 mb-xl-8">
                <!--بداية جسم البطاقة-->
                <div class="card-body">
                    <!--بداية الملخص-->
                    <!--بداية معلومات المستخدم-->
                    <div class="d-flex flex-center flex-column py-5">
                        <!--بداية الصورة الرمزية-->
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            @if ($user->avatar)
                                <img src="{{ $user->getProfilePhotoUrlAttribute() }}" alt="صورة" />
                            @else
                                <div
                                    class="symbol-label fs-3 {{ app(\App\Actions\GetThemeType::class)->handle('bg-light-? text-?', $user->name) }}">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <!--نهاية الصورة الرمزية-->
                        <!--بداية الاسم-->
                        <a href="#"
                            class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->name }}</a>
                        <!--نهاية الاسم-->
                        <!--بداية المنصب-->
                        <div class="mb-9">
                            @foreach ($user->roles as $role)
                                <!--بداية الشارة-->
                                <div class="badge badge-lg badge-light-primary d-inline">{{ ucwords($role->name) }}
                                </div>
                                <!--بداية الشارة-->
                            @endforeach
                        </div>
                    </div>
                    <!--نهاية معلومات المستخدم-->

                    <!--بداية تبديل التفاصيل-->
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details"
                            role="button" aria-expanded="false" aria-controls="kt_user_view_details">التفاصيل
                            <span class="ms-2 rotate-180">
                                <i class="ki-duotone ki-down fs-3"></i>
                            </span>
                        </div>
                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" title="تعديل تفاصيل العميل">
                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                data-bs-target="#kt_modal_update_details">تعديل</a>
                        </span>
                    </div>
                    <!--نهاية تبديل التفاصيل-->

                    <div class="separator"></div>

                    <!--بداية محتوى التفاصيل-->
                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <!--بداية عنصر التفاصيل-->
                            <div class="fw-bold mt-5">معرف الحساب</div>
                            <div class="text-gray-600">ID-{{ $user->id }}</div>
                            <!--بداية عنصر التفاصيل-->
                            <!--بداية عنصر التفاصيل-->
                            <div class="fw-bold mt-5">البريد الإلكتروني</div>
                            <div class="text-gray-600">
                                <a href="mailto:{{ $user->email }}" class="text-gray-600 text-hover-primary">
                                    {{ $user->email }} </a>
                            </div>
                            <!--بداية عنصر التفاصيل-->
                            <!--بداية عنصر التفاصيل-->
                            <div class="fw-bold mt-5">العنوان</div>
                            <div class="text-gray-600">
                                @isset($user->getDefaultAddressAttribute()->address_line_1)
                                    {{ $user->getDefaultAddressAttribute()->address_line_1 }}
                                    <br>
                                    {{ $user->getDefaultAddressAttribute()->address_line_2 ?? null }}
                                    <br>
                                    {{ $user->getDefaultAddressAttribute()->city }}
                                    <br>
                                    {{ $user->getDefaultAddressAttribute()->postal_code }}
                                    <br>
                                    {{ $user->getDefaultAddressAttribute()->state }}
                                    <br>
                                    {{ $user->getDefaultAddressAttribute()->country }}
                                @endisset
                            </div>
                            <!--بداية عنصر التفاصيل-->
                            <div class="fw-bold mt-5">آخر تسجيل دخول</div>
                            <div class="text-gray-600"> منذ
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : $user->updated_at->diffForHumans() }}
                            </div>
                            <!--بداية عنصر التفاصيل-->
                        </div>
                    </div>
                    <!--نهاية محتوى التفاصيل-->

                </div>
                <!--نهاية جسم البطاقة-->
            </div>
            <!--نهاية البطاقة-->
        </div>
        <!--نهاية الشريط الجانبي-->
        <!--بداية المحتوى-->
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--بداية الشريط التبويبي-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <!--بداية العنصر-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-kt-countup-tabs="true" data-bs-toggle="tab"
                        href="#kt_user_view_overview_security">الأمن</a>
                </li>
                <!--نهاية العنصر-->

            </ul>
            <!--نهاية الشريط التبويبي-->
            <!--بداية محتوى التبويب-->
            <div class="tab-content" id="myTabContent">
                <!--بداية الشريط-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_security" role="tabpanel">
                    <!--بداية البطاقة-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--بداية الرأس-->
                        <div class="card-header border-0">
                            <!--بداية العنوان-->
                            <div class="card-title">
                                <h2>الملف الشخصي</h2>
                            </div>
                            <!--نهاية العنوان-->
                        </div>
                        <!--نهاية الرأس-->
                        <!--بداية الجسم-->
                        <div class="card-body pt-0 pb-5">
                            <!--بداية الجدول-->
                            <div class="table-responsive">
                                <!--بداية الجدول-->
                                <table class="table align-middle table-row-dashed gy-5"
                                    id="kt_table_users_login_session">
                                    <tbody class="fs-6 fw-semibold text-gray-600">
                                        <tr>
                                            <td>البريد الإلكتروني</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_email">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>كلمة المرور</td>
                                            <td>******</td>
                                            <td class="text-end">
                                                <button type="button"
                                                    class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                                    data-bs-toggle="modal" data-bs-target="#kt_modal_update_password">
                                                    <i class="ki-duotone ki-pencil fs-3">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>الاسم</td>
                                            <td>
                                                {{ $user->name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--نهاية الجدول-->
                            </div>
                            <!--نهاية الجدول-->
                        </div>
                        <!--نهاية الجسم-->
                    </div>
                    <!--نهاية البطاقة-->
                    {{-- <!--بداية البطاقة-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--بداية الرأس-->
                        <div class="card-header border-0">
                            <!--بداية العنوان-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">تأكيد الخطوة الثانية</h2>
                                <div class="fs-6 fw-semibold text-muted">احمل حسابك الإضافي بأمان عن طريق خطوة ثانية.</div>
                            </div>
                            <!--نهاية العنوان-->
                            <!--بداية الأدوات-->
                            <div class="card-toolbar">
                                <!--بداية الزر-->
                                <button type="button" class="btn btn-light-primary btn-sm" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <i class="ki-duotone ki-fingerprint-scanning fs-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>إضافة خطوة تأكيد</button>
                                <!--بداية القائمة-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-6 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--بداية العنصر-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_auth_app">استخدم تطبيق التأكيد</a>
                                    </div>
                                    <!--نهاية العنصر-->
                                    <!--بداية العنصر-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_add_one_time_password">تمكين كلمة المرور الواحدة</a>
                                    </div>
                                    <!--نهاية العنصر-->
                                </div>
                                <!--نهاية القائمة-->
                                <!--نهاية الزر-->
                            </div>
                            <!--نهاية الأدوات-->
                        </div>
                        <!--نهاية الرأس-->
                        <!--بداية الجسم-->
                        <div class="card-body pb-5">
                            <!--بداية العنصر-->
                            <div class="d-flex flex-stack">
                                <!--بداية المحتوى-->
                                <div class="d-flex flex-column">
                                    <span>الرسائل القصوى</span>
                                    <span class="text-muted fs-6">+61 412 345 678</span>
                                </div>
                                <!--نهاية المحتوى-->
                                <!--بداية العملية-->
                                <div class="d-flex justify-content-end align-items-center">
                                    <!--بداية الزر-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto me-5"
                                        data-bs-toggle="modal" data-bs-target="#kt_modal_add_one_time_password">
                                        <i class="ki-duotone ki-pencil fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                    <!--نهاية الزر-->
                                    <!--بداية الزر-->
                                    <button type="button"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px ms-auto"
                                        id="kt_users_delete_two_step">
                                        <i class="ki-duotone ki-trash fs-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </button>
                                    <!--نهاية الزر-->
                                </div>
                                <!--نهاية العملية-->
                            </div>
                            <!--نهاية العنصر-->
                            <!--بداية الفاصل-->
                            <div class="separator separator-dashed my-5"></div>
                            <!--نهاية الفاصل-->
                            <!--بداية التفسير-->
                            <div class="text-gray-600">إذا فقدت جهازك المحمول أو حلقة الأمان، يمكنك
                                <a href='#' class="me-1">إنشاء رمز استعادة</a>لتسجيل الدخول إلى حسابك.
                            </div>
                            <!--نهاية التفسير-->
                        </div>
                        <!--نهاية الجسم-->
                    </div>
                    <!--نهاية البطاقة--> --}}
                    {{-- <!--بداية البطاقة-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--بداية الرأس-->
                        <div class="card-header border-0">
                            <!--بداية العنوان-->
                            <div class="card-title flex-column">
                                <h2>الإشعارات البريدية</h2>
                                <div class="fs-6 fw-semibold text-muted">حالب على اختيار ما سيتلقاك لكل حساب من حساباتك.</div>
                            </div>
                            <!--نهاية العنوان-->
                        </div>
                        <!--نهاية الرأس-->
                        <!--بداية الجسم-->
                        <div class="card-body">
                            <!--بداية النموذج-->
                            <form class="form" id="kt_users_email_notification_form">
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_0"
                                            type="checkbox" value="0" id="kt_modal_update_email_notification_0"
                                            checked='checked' />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_0">
                                            <div class="fw-bold">الدفع الناجح</div>
                                            <div class="text-gray-600">يتلقى إشعار لكل دفع ناجح.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_1"
                                            type="checkbox" value="1"
                                            id="kt_modal_update_email_notification_1" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_1">
                                            <div class="fw-bold">السحب</div>
                                            <div class="text-gray-600">يتلقى إشعار لكل سحب بدأت.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_2"
                                            type="checkbox" value="2"
                                            id="kt_modal_update_email_notification_2" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_2">
                                            <div class="fw-bold">رسوم التطبيق</div>
                                            <div class="text-gray-600">يتلقى إشعار كل مرة يجمع فيها مبلغ من حساب.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_3"
                                            type="checkbox" value="3" id="kt_modal_update_email_notification_3"
                                            checked='checked' />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_3">
                                            <div class="fw-bold">النزاعات</div>
                                            <div class="text-gray-600">يتلقى إشعار إذا كانت عملية دفع معترضة من قبل عميل ولتسوية النزاع.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_4"
                                            type="checkbox" value="4" id="kt_modal_update_email_notification_4"
                                            checked='checked' />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_4">
                                            <div class="fw-bold">مراجع الدفع</div>
                                            <div class="text-gray-600">يتلقى إشعار إذا كانت عملية دفع معترضة من عميل ولتسوية الخطورة.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_5"
                                            type="checkbox" value="5"
                                            id="kt_modal_update_email_notification_5" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_5">
                                            <div class="fw-bold">التذكير</div>
                                            <div class="text-gray-600">يتلقى إشعار إذا كان صديق يذكرك في ملاحظة.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_6"
                                            type="checkbox" value="6"
                                            id="kt_modal_update_email_notification_6" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_6">
                                            <div class="fw-bold">رسائل الفواتير الخطأ</div>
                                            <div class="text-gray-600">يتلقى إشعار إذا كان عميل يرسل مبلغ خطأ إلى سداد فاتورته.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_7"
                                            type="checkbox" value="7"
                                            id="kt_modal_update_email_notification_7" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_7">
                                            <div class="fw-bold">الوكيوت</div>
                                            <div class="text-gray-600">يتلقى إشعارات عن النهايات المتكررة لنهايات الوكيوت.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--بداية العنصر-->
                                <div class="d-flex">
                                    <!--بداية الخانة المربعية-->
                                    <div class="form-check form-check-custom form-check-solid">
                                        <!--بداية الحقل-->
                                        <input class="form-check-input me-3" name="email_notification_8"
                                            type="checkbox" value="8"
                                            id="kt_modal_update_email_notification_8" />
                                        <!--نهاية الحقل-->
                                        <!--بداية التسمية-->
                                        <label class="form-check-label" for="kt_modal_update_email_notification_8">
                                            <div class="fw-bold">التجربة</div>
                                            <div class="text-gray-600">يتلقى نصائح مفيدة عندما تحاول استخدام منتجاتنا.</div>
                                        </label>
                                        <!--نهاية التسمية-->
                                    </div>
                                    <!--نهاية الخانة المربعية-->
                                </div>
                                <!--نهاية العنصر-->
                                <!--بداية الأزرار-->
                                <div class="d-flex justify-content-end align-items-center mt-12">
                                    <!--بداية الزر-->
                                    <button type="button" class="btn btn-light me-5"
                                        id="kt_users_email_notification_cancel">إلغاء</button>
                                    <!--نهاية الزر-->
                                    <!--بداية الزر-->
                                    <button type="button" class="btn btn-primary"
                                        id="kt_users_email_notification_submit">
                                        <span class="indicator-label">حفظ</span>
                                        <span class="indicator-progress">يرجى الإنتظار...
                                            <span
                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                    <!--نهاية الزر-->
                                </div>
                                <!--نهاية الأزرار-->
                            </form>
                            <!--نهاية النموذج-->
                        </div>
                        <!--نهاية الجسم-->
                        <!--بداية الجسم الختامي-->
                        <!--نهاية الجسم الختامي-->
                    </div>
                    <!--نهاية البطاقة--> --}}
                </div>
                <!--نهاية الشريط-->
            </div>
            <!--نهاية محتوى التبويب-->
        </div>
        <!--نهاية المحتوى-->
    </div>
    <!--نهاية التخطيط-->
    <!--بداية المودالات-->
    <!--بداية المودال - تحديث تفاصيل المستخدم-->
    {{-- @include('pages/apps/user-management/users/modals/_update-details') --}}
    <livewire:user.edit-user-modal></livewire:user.edit-user-modal>
    <!--نهاية المودال - تحديث تفاصيل المستخدم-->
    <!--بداية المودال - إضافة جدول-->
    {{-- @include('pages/apps/user-management/users/modals/_add-schedule') --}}
    <!--نهاية المودال - إضافة جدول-->
    <!--بداية المودال - إضافة حلقة واحدة-->
    {{-- @include('pages/apps/user-management/users/modals/_add-one-time-password') --}}
    <!--نهاية المودال - إضافة حلقة واحدة-->
    <!--بداية المودال - تحديث البريد الإلكتروني-->
    {{-- @include('pages/apps/user-management/users/modals/_update-email') --}}
    <livewire:user.edit-user-email-modal></livewire:user.edit-user-email-modal>
    <!--نهاية المودال - تحديث البريد الإلكتروني-->
    <!--بداية المودال - تحديث كلمة المرور-->
    {{-- @include('pages/apps/user-management/users/modals/_update-password') --}}
    <livewire:user.edit-user-password-modal></livewire:user.edit-user-password-modal>

    <!--نهاية المودال - تحديث كلمة المرور-->
    <!--بداية المودال - تحديث الدور-->
    {{-- @include('pages/apps/user-management/users/modals/_update-role') --}}
    <!--نهاية المودال - تحديث الدور-->
    <!--بداية المودال - إضافة تطبيق التأكيد-->
    {{-- @include('pages/apps/user-management/users/modals/_add-auth-app') --}}
    <!--نهاية المودال - إضافة تطبيق التأكيد-->
    <!--بداية المودال - إضافة عمل-->
    {{-- @include('pages/apps/user-management/users/modals/_add-task') --}}
    <!--نهاية المودال - إضافة عمل-->

</x-default-layout>
