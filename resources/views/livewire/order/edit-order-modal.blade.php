<div class="modal fade" id="kt_modal_edit_order" tabindex="-1" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_edit_order_header">
                <h2 class="fw-bold">تعديل طلب</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="إغلاق">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_edit_order_form" class="form" wire:submit="submit" enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_edit_order_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_edit_order_header"
                        data-kt-scroll-wrappers="#kt_modal_edit_order_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">العنوان</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" wire:model="order_id" name="order_id" value="{{ $order_id }}" />
                            <input type="text" wire:model="title" name="title"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="عنوان لطلب" />
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
                            <label class="fw-semibold fs-6 mb-2">المرفقات الحالية</label>
                            <div class="current-attachments d-flex flex-wrap gap-2 mb-3">
                                <!-- سيتم ملؤا بواسطة JavaScript -->
                            </div>

                            <label class="fw-semibold fs-6 mb-2">إضافة مرفقات جديدة</label>
                            <div class="position-relative">
                                <input type="file" wire:model="attachments" name="attachments[]"
                                    class="form-control form-control-solid" multiple
                                    wire:loading.attr="disabled">
                                <div wire:loading wire:target="attachments" class="position-absolute top-50 end-0 translate-middle-y me-3">
                                    <span class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">جاري التحميل...</span>
                                    </span>
                                </div>
                            </div>
                            <div class="temporary-files-preview mt-3">
                                <!-- سيتم ملؤها بواسطة JavaScript -->
                            </div>
                            @error('attachments.*')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->

                        <div class="mb-7">
                            <label class="fw-semibold fs-6 mb-2">المتطلبات</label>
                            <div class="d-flex mb-2">
                                <input type="text" id="editNewRequirement"
                                    class="form-control form-control-solid me-3" placeholder="أدخل عنوان المتطلب" />
                                <button type="button" class="btn btn-primary" id="editAddRequirement">
                                    إضافة متطلب
                                </button>
                            </div>

                            <div id="editRequirementsList"></div>

                            <input type="hidden" wire:model="requirements" id="editRequirementsInput"
                                name="requirements">
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="إغلاق"
                                wire:loading.attr="disabled">تجاهل</button>
                            <button type="submit" class="btn btn-primary" data-kt-orders-modal-action="submit">
                                <span class="indicator-label" wire:loading.remove>حفظ التغييرات</span>
                                <span class="indicator-progress" wire:loading wire:target="submit">
                                    يرجى الانتظار...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // تعريف الدالة في النطاق العام (window)
        window.deleteAttachment = function(attachmentId) {
            Livewire.dispatch('deleteAttachment', [attachmentId]);
        }

        document.addEventListener('DOMContentLoaded', function() {
            function updateEditAttachmentsList(attachments) {
                const attachmentsContainer = document.querySelector('.current-attachments');
                attachmentsContainer.innerHTML = '';

                const attachmentsArray = Array.isArray(attachments) ? attachments : [attachments];

                attachmentsArray.forEach(attachment => {
                    const attachmentElement = document.createElement('div');
                    attachmentElement.className =
                        'attachment-item border rounded p-3 d-flex align-items-center bg-light-primary';
                    attachmentElement.innerHTML = `
                        <i class="fas fa-file me-2"></i>
                        <a href="/storage/${attachment.file_path}" target="_blank" class="text-hover-primary me-2">
                            ${attachment.file_name}
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-icon btn-danger ms-2"
                                onclick="deleteAttachment(${attachment.id})">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    attachmentsContainer.appendChild(attachmentElement);
                });
            }

            // استماع للأحداث
            Livewire.on('initializeAttachments', attachments => {
                updateEditAttachmentsList(attachments[0]);
            });

            Livewire.on('attachmentsUpdated', attachments => {
                updateEditAttachmentsList(attachments[0]);
            });

            let requirements = [];
            const newRequirementInput = document.getElementById('editNewRequirement');
            const addRequirementButton = document.getElementById('editAddRequirement');
            const requirementsList = document.getElementById('editRequirementsList');
            const requirementsInput = document.getElementById('editRequirementsInput');

            function addNewRequirement() {
                const newReq = newRequirementInput.value.trim();
                if (newReq) {
                    requirements.push(newReq);
                    newRequirementInput.value = '';
                    updateRequirementsList();
                    @this.set('requirements', requirements);
                    newRequirementInput.focus();
                }
            }

            // إضافة متطلب عند الضغط على Shift + Space
            newRequirementInput.addEventListener('keydown', function(e) {
                if (e.shiftKey && e.code === 'Space') {
                    e.preventDefault();
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
            }

            requirementsList.addEventListener('click', function(e) {
                if (e.target.tagName === 'BUTTON') {
                    const index = parseInt(e.target.getAttribute('data-index'));
                    requirements.splice(index, 1);
                    updateRequirementsList();
                    @this.set('requirements', requirements);
                }
            });

            // استقبال المتطلبات الحالية عند فتح النموذج
            Livewire.on('initializeRequirements', reqs => {
                requirements = reqs[0];
                updateRequirementsList();
            });
        });
    </script>
@endpush
