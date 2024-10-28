<x-default-layout>
    @section('title')
        الطلبات
    @endsection


    @section('breadcrumbs')
        {{ Breadcrumbs::render('order-management.orders.index') }}
    @endsection

    <div class="card d-flex flex-column">
        <style>
            .list-requirements {
                padding-right: 20px;
                margin: 0;
                max-height: 150px;
                overflow-y: auto;
            }

            .requirement-item {
                margin-bottom: 5px;
                font-size: 0.9em;
            }

            #requirementsList {
                list-style-type: none;
                padding: 0;
            }

            .requirement-item {
                background-color: #f8f9fa;
                border-radius: 5px;
                padding: 10px;
                transition: background-color 0.3s;
            }

            .requirement-item:hover {
                background-color: #e9ecef;
            }
        </style>
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    {!! getIcon('magnifier', 'fs-3 position-absolute ms-5') !!}
                    <input type="text" data-kt-order-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="بحث عن طلب"
                        id="mySearchInput" />
                </div>
                <!--end::Search-->

                <!--begin::Date filters-->
                <div class="d-flex align-items-center mx-3">
                    <input type="date" id="start_date" class="form-control form-control-solid me-2"
                        placeholder="من تاريخ">
                    <input type="date" id="end_date" class="form-control form-control-solid"
                        placeholder="إلى تاريخ">
                    <button id="filterDates" class="btn btn-primary ms-2">تصفية</button>
                    <button id="resetDates" class="btn btn-secondary ms-2 w-100">إعادة تعيين</button>
                </div>
                <!--end::Date filters-->
            </div>
            <!--begin::Card title-->

            <!--begin::Card toolbar-->
            <div class="card-toolbar">

                @can('create order')
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end" data-kt-order-table-toolbar="base">
                        <!--begin::Add order-->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_order">
                            {!! getIcon('plus', 'fs-2', '', 'i') !!}
                            إضافة طلب
                        </button>
                        <!--end::Add order-->
                    </div>
                    <!--end::Toolbar-->
                @endcan

                <!--begin::Modal-->
                <livewire:order.add-order-modal></livewire:order.add-order-modal>

                <!--end::Modal-->
            </div>
            <!--end::Card toolbar-->

        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4 w-100">
            <!--begin::Table-->
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
            <!--end::Table-->
        </div>
        <!--end::Card body-->


        <!-- Requirements Modal -->
        <div class="modal fade" id="requirementsModal" tabindex="-1" aria-labelledby="requirementsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="requirementsModalLabel">متطلبات الطلب</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>حالة الطلب: </strong><span id="orderStatus"></span></p>
                        <ul id="requirementsList"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <livewire:order.edit-order-modal></livewire:order.edit-order-modal>

    @push('scripts')
        {{ $dataTable->scripts() }}

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const requirementsModal = document.getElementById('requirementsModal');
                requirementsModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const requirements = JSON.parse(button.getAttribute('data-requirements'));
                    const orderStatus = button.getAttribute('data-order-status');

                    const modalBody = this.querySelector('.modal-body');
                    const requirementsList = modalBody.querySelector('#requirementsList');
                    const orderStatusElement = modalBody.querySelector('#orderStatus');

                    orderStatusElement.textContent = orderStatus;
                    orderStatusElement.className = 'badge badge-' + getStatusColor(orderStatus);

                    requirementsList.innerHTML = '';
                    requirements.forEach(function(requirement) {
                        const li = document.createElement('li');
                        li.className =
                            'requirement-item d-flex justify-content-between align-items-center mb-2';
                        li.innerHTML = `
                            <span>${requirement.title}</span>
                            <span class="badge badge-${getStatusColor(requirement.status)}">${requirement.status}</span>
                        `;
                        requirementsList.appendChild(li);
                    });
                });
            });

            function getStatusColor(status) {
                switch (status) {
                    case 'معلق':
                        return 'warning';
                    case 'غير منجز':
                        return 'info';
                    case 'مكتمل':
                        return 'success';
                    case 'ملغي':
                        return 'danger';
                    default:
                        return 'secondary';
                }
            }

            document.getElementById('mySearchInput').addEventListener('keyup', function() {
                window.LaravelDataTables['orders-table'].search(this.value).draw();
            });
            document.addEventListener('livewire:init', function() {
                Livewire.on('success', function() {
                    $('#kt_modal_add_order').modal('hide');
                    window.LaravelDataTables['orders-table'].ajax.reload();
                });
            });
            $('#kt_modal_add_order').on('hidden.bs.modal', function() {
                Livewire.dispatch('new_order');
            });

            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    toastr.success('تم نسخ المعرف بنجاح!');
                }, function(err) {
                    console.error('فشل في نسخ النص: ', err);
                    toastr.error('فشل في نسخ النص');
                });
            }

            // إضافة كود تصفية التواريخ
            document.getElementById('filterDates').addEventListener('click', function() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                window.LaravelDataTables['orders-table'].ajax.reload(null, false);
            });

            document.getElementById('resetDates').addEventListener('click', function() {
                document.getElementById('start_date').value = '';
                document.getElementById('end_date').value = '';
                window.LaravelDataTables['orders-table'].ajax.reload(null, false);
            });
        </script>
    @endpush

</x-default-layout>
