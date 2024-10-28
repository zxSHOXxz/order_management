<div class="modal fade" id="kt_modal_add_project" tabindex="-1" aria-hidden="true" wire:ignore>
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header" id="kt_modal_add_project_header">
                <h2 class="fw-bold">Add project</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    {!! getIcon('cross', 'fs-1') !!}
                </div>
            </div>
            <div class="modal-body px-5 my-7">
                <form id="kt_modal_add_project_form" class="form" wire:submit="submit" enctype="multipart/form-data">
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_project_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#kt_modal_add_project_header"
                        data-kt-scroll-wrappers="#kt_modal_add_project_scroll" data-kt-scroll-offset="300px">

                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">image</label>
                            <input type="file" wire:model="image" name="image"
                                class="form-control form-control-solid mb-3 mb-lg-0" />

                            @if ($image && $edit_mode == false)
                                <div class="mt-2">
                                    <img src="{{ $image->temporaryUrl() }}" alt="Image Preview" class="img-thumbnail"
                                        width="200" />
                                </div>
                            @endif

                            <div class="uploading" wire:loading wire:target="image">
                                <span class="text-muted"> Uploading...
                                </span>
                            </div>
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="hidden" wire:model="project_id" name="project_id"
                                value="{{ $project_id }}" />
                            <input type="text" wire:model="name" name="name"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Project Name" />
                            <!--end::Input-->
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" wire:model="description" name="description"
                                class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Front-end" />
                            <!--end::Input-->
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Compleation Date</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="date" wire:model="completion_date" name="completion_date"
                                class="form-control form-control-solid mb-3 mb-lg-0" />
                            <!--end::Input-->
                            @error('completion_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <div class="form-check form-switch form-check-custom form-check-success form-check-solid">
                                <input class="form-check-input" type="checkbox" wire:model="status"
                                    id="kt_flexSwitchCustomDefault_1_1" />
                                <label class="form-check-label" for="kt_flexSwitchCustomDefault_1_1">
                                    Status
                                </label>
                            </div>
                            <!--end::Input-->
                            @error('status')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--end::Input group-->


                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Tags</label>
                            <div wire:ignore>
                                <select class="form-select form-select-lg form-select-solid" data-control="select2"
                                    data-placeholder="Select an option" data-allow-clear="true"
                                    data-close-on-select="true" multiple="multiple" id="tag_ids">
                                    <option></option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->title }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>

                        <!--end::Scroll-->


                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal" aria-label="Close"
                                wire:loading.attr="disabled">Discard</button>
                            <button type="submit" class="btn btn-primary" data-kt-projects-modal-action="submit">
                                <span class="indicator-label" wire:loading.remove>Submit</span>
                                <span class="indicator-progress" wire:loading wire:target="submit">
                                    Please wait...
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
        $(document).ready(function() {
            $('#tag_ids').select2();

            $('#tag_ids').on('change', function(e) {
                var data = $(this).val();
                @this.set('tag_ids', data);
            });
            window.addEventListener('tagsUpdated', event => {
                $('#tag_ids').val(event.detail[0].tags).trigger('change');
            });
        });
    </script>
@endpush
