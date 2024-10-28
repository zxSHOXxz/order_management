<div class="modal fade" id="kt_modal_add_order" tabindex="-2" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_order_header">
                <h2 class="fw-bold">إضافة طلب</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="إغلاق">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_order_form" class="form" wire:submit="submit" enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_order_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_order_header"
                        data-kt-scroll-wrappers="#kt_modal_add_order_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">العنوان</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" wire:model="order_id" name="order_id" value="{{ $order_id }}" />
                            <input type="text" wire:model="title" name="title"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="عنوان الطلب" />
                            <!--end::Input-->
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">التفاصيل</label>
                            <!--end::Label-->

                            <textarea wire:model="details" name="details" class="form-control form-control-solid mb-3 mb-lg-0"
                                placeholder="أضف تفاصيل الطلب هنا .... "></textarea>
                            <!--end::Input-->
                            @error('details')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">الملحقات</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" wire:model="attachments" name="attachments[]"
                                class="form-control form-control-solid" multiple>
                            <!--end::Input-->
                            @error('attachments.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->

                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">المتطلبات</label>

                            <div class="d-flex mb-2">
                                <input type="text" id="newRequirement" class="form-control form-control-solid me-3"
                                    placeholder="أدخل عنوان المتطلب" />
                                <button type="button" class="btn btn-primary" id="addRequirement">إضافة
                                    متطلب</button>
                            </div>

                            <div id="requirementsList"></div>

                            <input type="hidden" wire:model="requirements[]" id="requirementsInput"
                                name="requirements">
                        </div>


                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="إغلاق"
                                wire:loading.attr="disabled">تجاهل</button>
                            <button type="submit" class="btn btn-primary" data-kt-orders-modal-action="submit">
                                <span class="indicator-label" wire:loading.remove>إرسال</span>
                                <span class="indicator-progress" wire:loading wire:target="submit">
                                    يرجى الانتظار...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->

</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let requirements = [];
            const newRequirementInput = document.getElementById('newRequirement');
            const addRequirementButton = document.getElementById('addRequirement');
            const requirementsList = document.getElementById('requirementsList');
            const requirementsInput = document.getElementById('requirementsInput');

            function addNewRequirement() {
                const newReq = newRequirementInput.value.trim();
                if (newReq) {
                    requirements.push(newReq);
                    newRequirementInput.value = '';
                    updateRequirementsList();
                    @this.set('requirements', requirements);
                    // تحديد حقل الإدخال تلقائياً بعد الإضافة
                    newRequirementInput.focus();
                }
            }

            // إضافة مستمع حدث للضغط على المفاتيح
            newRequirementInput.addEventListener('keydown', function(e) {
                // التحقق من ضغط Shift + Space
                if (e.shiftKey && e.code === 'Space') {
                    e.preventDefault(); // منع إضافة مسافة في حقل الإدخال
                    addNewRequirement();
                }
            });

            addRequirementButton.addEventListener('click', addNewRequirement);

            function updateRequirementsList() {
                requirementsList.innerHTML = '';
                requirements.forEach((req, index) => {
                    const reqElement = document.createElement('div');
                    reqElement.className = 'd-flex mb-2 mt-2';
                    reqElement.innerHTML = `
                        <input type="text" value="${req}" class="form-control form-control-solid me-3" readonly />
                        <button type="button" class="btn btn-danger" data-index="${index}">إزالة</button>
                    `;
                    requirementsList.appendChild(reqElement);
                });
                requirementsInput.value = JSON.stringify(requirements);
                console.log(requirementsInput.value);

            }

            requirementsList.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON') {
                    const index = parseInt(e.target.getAttribute('data-index'));
                    requirements.splice(index, 1);
                    updateRequirementsList();
                }
            });

            // Initialize Livewire hook for form submission
            Livewire.hook('message.processed', (message, component) => {
                if (component.fingerprint.name === 'order.add-order-modal' && message.updateQueue.length >
                    0) {
                    requirements = [];
                    updateRequirementsList();
                }
            });
        });
    </script>
@endpush
