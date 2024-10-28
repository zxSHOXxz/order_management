<div class="modal fade" id="kt_modal_update_password" tabindex="-1" aria-hidden="true">
    <!--بداية مربع الحوار المشروط-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--بداية محتوى النافذة المنبثقة-->
        <div class="modal-content">
            <!--بداية رأس النافذة المنبثقة-->
            <div class="modal-header">
                <!--بداية عنوان النافذة المنبثقة-->
                <h2 class="fw-bold">تحديث كلمة المرور</h2>
                <!--نهاية عنوان النافذة المنبثقة-->
                <!--بداية زر الإغلاق-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--نهاية زر الإغلاق-->
            </div>
            <!--نهاية رأس النافذة المنبثقة-->
            <!--بداية جسم النافذة المنبثقة-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--بداية النموذج-->
                <form id="kt_modal_update_password_form" class="form" action="#">
                    <!--بداية مجموعة الإدخال-->
                    <div class="fv-row mb-10">
                        <label class="required form-label fs-6 mb-2">كلمة المرور الحالية</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="current_password" autocomplete="off" />
                    </div>
                    <!--نهاية مجموعة الإدخال-->
                    <!--بداية مجموعة الإدخال-->
                    <div class="mb-10 fv-row" data-kt-password-meter="true">
                        <!--بداية الغلاف-->
                        <div class="mb-1">
                            <!--بداية التسمية-->
                            <label class="form-label fw-semibold fs-6 mb-2">كلمة المرور الجديدة</label>
                            <!--نهاية التسمية-->
                            <!--بداية غلاف الإدخال-->
                            <div class="position-relative mb-3">
                                <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="new_password" autocomplete="off" />
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                    <i class="ki-duotone ki-eye-slash fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    <i class="ki-duotone ki-eye d-none fs-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </span>
                            </div>
                            <!--نهاية غلاف الإدخال-->
                            <!--بداية مقياس قوة كلمة المرور-->
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                            </div>
                            <!--نهاية مقياس قوة كلمة المرور-->
                        </div>
                        <!--نهاية الغلاف-->
                        <!--بداية التلميح-->
                        <div class="text-muted">استخدم 8 أحرف أو أكثر مع مزيج من الأحرف والأرقام والرموز.</div>
                        <!--نهاية التلميح-->
                    </div>
                    <!--نهاية مجموعة الإدخال-->
                    <!--بداية مجموعة الإدخال-->
                    <div class="fv-row mb-10">
                        <label class="form-label fw-semibold fs-6 mb-2">تأكيد كلمة المرور الجديدة</label>
                        <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" name="confirm_password" autocomplete="off" />
                    </div>
                    <!--نهاية مجموعة الإدخال-->
                    <!--بداية الإجراءات-->
                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">تجاهل</button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                            <span class="indicator-label">إرسال</span>
                            <span class="indicator-progress">الرجاء الانتظار...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--نهاية الإجراءات-->
                </form>
                <!--نهاية النموذج-->
            </div>
            <!--نهاية جسم النافذة المنبثقة-->
        </div>
        <!--نهاية محتوى النافذة المنبثقة-->
    </div>
    <!--نهاية مربع الحوار المشروط-->
</div>
