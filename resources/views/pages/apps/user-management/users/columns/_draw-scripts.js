// تهيئة KTMenu
KTMenu.init();

// إضافة مستمع حدث النقر لأزرار الحذف
document.querySelectorAll('[data-kt-action="delete_row"]').forEach(function (element) {
    element.addEventListener('click', function () {
        Swal.fire({
            text: 'هل أنت متأكد أنك تريد الإزالة؟',
            icon: 'warning',
            buttonsStyling: false,
            showCancelButton: true,
            confirmButtonText: 'نعم',
            cancelButtonText: 'لا',
            customClass: {
                confirmButton: 'btn btn-danger',
                cancelButton: 'btn btn-secondary',
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.dispatch('delete_user', [this.getAttribute('data-kt-user-id')]);
            }
        });
    });
});

// إضافة مستمع حدث النقر لأزرار التحديث
document.querySelectorAll('[data-kt-action="update_user_status"]').forEach(function (element) {
    console.log(element);

    element.addEventListener('click', function () {
        console.log(element);

        Livewire.dispatch('update_user_status', [this.getAttribute('data-kt-user-id')]);
    });
});

// الاستماع لحدث 'success' الذي يتم إرساله بواسطة Livewire
Livewire.on('success', (message) => {
    // إعادة تحميل جدول البيانات users-table
    LaravelDataTables['users-table'].ajax.reload();
});
